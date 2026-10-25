<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Grouping untuk User yang sudah login
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Scan
    Route::get('/scan', function () {
        return view('scan');
    })->name('scan.index');

    // Chat & Riwayat
    Route::get('/chat', function () {
        return view('chat');
    })->name('chat.index');
    
    // (Opsional) Route send untuk backend nanti
    Route::post('/chat', [ChatController::class, 'send'])->name('chat.send');

    Route::get('/history', function () {
        return view('history');
    })->name('history.index');

    // Settings & Help
    Route::get('/settings', function () {
        return view('settings');
    })->name('settings.index');

    Route::get('/help', function () {
        return view('help');
    })->name('help.index');
});

// Route bawaan Breeze untuk Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';