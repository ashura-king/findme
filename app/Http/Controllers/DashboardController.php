<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LostItem;
use App\Models\FoundItem;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get counts for stats cards
        $stats = [
            'lost_items' => LostItem::count(),
            'found_items' => FoundItem::count(),
            'returned_items' => LostItem::where('status', 'returned')->count() + 
                               FoundItem::where('status', 'returned')->count(),
            'active_users' => User::count(), // Total users for now
        ];

        // Get recent items (last 5)
        $recentLostItems = LostItem::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentFoundItems = FoundItem::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Calculate percentage changes
        $stats['lost_change'] = $this->calculateChange('lost');
        $stats['found_change'] = $this->calculateChange('found');
        $stats['returned_change'] = $this->calculateChange('returned');
        $stats['users_change'] = $this->calculateUserChange();

        return view('dashboard', compact('stats', 'recentLostItems', 'recentFoundItems'));
    }

    private function calculateChange($type)
    {
        $now = Carbon::now();
        $lastWeek = Carbon::now()->subWeek();
        
        switch ($type) {
            case 'lost':
                $current = LostItem::where('created_at', '>=', $now->startOfWeek())->count();
                $previous = LostItem::whereBetween('created_at', [$lastWeek->startOfWeek(), $lastWeek->endOfWeek()])->count();
                break;
            case 'found':
                $current = FoundItem::where('created_at', '>=', $now->startOfWeek())->count();
                $previous = FoundItem::whereBetween('created_at', [$lastWeek->startOfWeek(), $lastWeek->endOfWeek()])->count();
                break;
            case 'returned':
                $current = LostItem::where('status', 'returned')->where('created_at', '>=', $now->startOfWeek())->count() +
                          FoundItem::where('status', 'returned')->where('created_at', '>=', $now->startOfWeek())->count();
                $previous = LostItem::where('status', 'returned')->whereBetween('created_at', [$lastWeek->startOfWeek(), $lastWeek->endOfWeek()])->count() +
                           FoundItem::where('status', 'returned')->whereBetween('created_at', [$lastWeek->startOfWeek(), $lastWeek->endOfWeek()])->count();
                break;
            default:
                return 0;
        }

        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        return round((($current - $previous) / $previous) * 100);
    }

    private function calculateUserChange()
    {
        $now = Carbon::now();
        $lastWeek = Carbon::now()->subWeek();
        
        $current = User::where('created_at', '>=', $now->startOfWeek())->count();
        $previous = User::whereBetween('created_at', [$lastWeek->startOfWeek(), $lastWeek->endOfWeek()])->count();

        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        return round((($current - $previous) / $previous) * 100);
    }
}