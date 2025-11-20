<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FoundItemController;
use App\Http\Controllers\LostItemController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;

use Illuminate\Support\Facades\Route;


Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard',[DashboardController::class,'index']);
Route::get('/lost-items', [LostItemController::class, 'index'])->name('lost.index');

Route::get('/lost/create', [LostItemController::class, 'create'])->name('lost.create');

Route::post('/lost', [LostItemController::class, 'store'])->name('lost.store');

Route::get('/lost/{id}', [LostItemController::class, 'show'])->name('lost.show');

Route::get('/found', [FoundItemController::class, 'index'])->name('found.index');
Route::get('/found/create', [FoundItemController::class, 'create'])->name('found.create');
Route::post('/found', [FoundItemController::class, 'store'])->name('found.store');
Route::get('/found/{id}', [FoundItemController::class, 'show'])->name('found.show');
Route::get('/map', [MapController::class, 'index'])->name('map');
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');