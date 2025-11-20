<?php

namespace App\Http\Controllers;

use App\Models\FoundItem;
use App\Models\LostItem;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the 5 most recent lost items
        $recentLostItems =LostItem::where('status', 'lost')
                            ->latest()
                            ->take(5)
                            ->get();

        // Get the 5 most recent found items
        $recentFoundItems = FoundItem::where('status', 'unclaimed')
                            ->latest()
                            ->take(5)
                            ->get();

        // Return dashboard view with data
        return view('dashboard', compact('recentLostItems', 'recentFoundItems'));
    } 
}