<?php

use App\Http\Controllers\FoundItemController;
use App\Http\Controllers\LostItemController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LostItemController::class, 'index'])->name('lost.index');

// Show form to create a lost item
Route::get('/lost/create', [LostItemController::class, 'create'])->name('lost.create');

// Store the lost item
Route::post('/lost', [LostItemController::class, 'store'])->name('lost.store');

// Show a specific lost item
Route::get('/lost/{id}', [LostItemController::class, 'show'])->name('lost.show');