<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatPageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Grouping untuk User yang sudah login
Route::middleware(['auth', 'verified'])->group(function () {

    // ================= USER ROUTES =================
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/scan', function () {
        return view('scan');
    })->name('scan.index');

    Route::post('/scan', [ScanController::class, 'store'])
        ->middleware('throttle:10,1')
        ->name('scan.store');

    Route::get('/chat/{scan?}', ChatPageController::class)->name('chat.index');

    Route::post('/chat/send', [ChatController::class, 'sendDirect'])
        ->middleware('throttle:30,1')
        ->name('chat.send');

    Route::post('/chat/{scan}/send', [ChatController::class, 'send'])
        ->middleware('throttle:30,1')
        ->name('chat.send.scan');

    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
    Route::get('/history/export', [HistoryController::class, 'export'])->name('history.export');
    Route::get('/settings', SettingsController::class)->name('settings.index');

    Route::get('/help', HelpController::class)->name('help.index');

    // ================= ADMIN ROUTES =================
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/monitoring', [AdminController::class, 'monitoring'])->name('admin.monitoring');
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');

        Route::get('/admin/export-csv', [AdminController::class, 'exportCsv'])->name('admin.export.csv');
    });
});

// Route bawaan Breeze untuk Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
