<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Scan;

Route::get('/', function () {
    return view('welcome');
});

// Grouping untuk User yang sudah login
Route::middleware(['auth', 'verified'])->group(function () {

    // ================= USER ROUTES =================
    Route::get('/dashboard', function () {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $totalScans = $user->scans()->count();
        $scanObat = $user->scans()->where('type', 'obat')->count();
        $scanLuka = $user->scans()->where('type', 'luka')->count();
        $recentScans = $user->scans()->latest()->take(3)->get();
        $latestScan = $user->scans()->latest()->first();

        return view('dashboard', compact('totalScans', 'scanObat', 'scanLuka', 'recentScans', 'latestScan'));
    })->name('dashboard');

    Route::get('/scan', function () {
        return view('scan');
    })->name('scan.index');

    Route::post('/scan', [ScanController::class, 'store'])->name('scan.store');

    Route::get('/chat/{scan?}', function (\App\Models\Scan $scan = null) {
        return view('chat', ['scan' => $scan]);
    })->name('chat.index');

    // PERUBAHAN: Tambahkan tanda tanya (?) agar scan opsional
    Route::post('/chat/{scan?}/send', [ChatController::class, 'send'])->name('chat.send');

    Route::get('/history', function () {
        $scans = Auth::user()->scans()->latest()->get();
        return view('history', compact('scans'));
    })->name('history.index');

    Route::get('/settings', function () {
        return view('settings');
    })->name('settings.index');

    Route::get('/help', function () {
        return view('help');
    })->name('help.index');


    // ================= ADMIN ROUTES =================
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/monitoring', [AdminController::class, 'monitoring'])->name('admin.monitoring');
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/admin/reports', [AdminController::class, 'dashboard'])->name('admin.reports');

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