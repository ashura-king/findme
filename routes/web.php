<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FoundItemController;
use App\Http\Controllers\LostItemController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;


Route::get('/',[DashboardController::class,'index'])->name('dashboard');
Route::get('/lost', [LostItemController::class, 'index'])->name('lost.index');

Route::get('/lost/create', [LostItemController::class, 'create'])->name('lost.create');

Route::post('/lost', [LostItemController::class, 'store'])->name('lost.store');

Route::get('/lost/{id}', [LostItemController::class, 'show'])->name('lost.show');