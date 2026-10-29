<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ScanController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Scan;

Route::get('/', function () {
    return view('welcome');
});

// Grouping untuk User yang sudah login
Route::middleware(['auth', 'verified'])->group(function () {

    // ================= USER ROUTES =================
    // Dashboard (Dinamis)
    Route::get('/dashboard', function () {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Statistik
        $totalScans = $user->scans()->count();
        $scanObat = $user->scans()->where('type', 'obat')->count();
        $scanLuka = $user->scans()->where('type', 'luka')->count();

        // Ambil riwayat terbaru (3 data)
        $recentScans = $user->scans()->latest()->take(3)->get();

        // Ambil scan terakhir untuk ditampilkan besar di kiri
        $latestScan = $user->scans()->latest()->first();

        return view('dashboard', compact('totalScans', 'scanObat', 'scanLuka', 'recentScans', 'latestScan'));
    })->name('dashboard');

    // Scan
    Route::get('/scan', function () {
        return view('scan');
    })->name('scan.index');

    Route::post('/scan', [ScanController::class, 'store'])->name('scan.store');

    // Chat & Riwayat
    Route::get('/chat/{scan?}', function (\App\Models\Scan $scan = null) {
        return view('chat', ['scan' => $scan]);
    })->name('chat.index');

    Route::post('/chat/{scan}/send', [ChatController::class, 'send'])->name('chat.send');

    // History
    Route::get('/history', function () {
        $scans = Auth::user()->scans()->latest()->get();
        return view('history', compact('scans'));
    })->name('history.index');

    // Settings & Help
    Route::get('/settings', function () {
        return view('settings');
    })->name('settings.index');

    Route::get('/help', function () {
        return view('help');
    })->name('help.index');


    // ================= ADMIN ROUTES =================
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/monitoring', function () {
        return view('admin.monitoring'); // <-- SUDAH DIFIX
    })->name('admin.monitoring');

    Route::get('/admin/users', function () {
        return view('admin.users'); // <-- SUDAH DIFIX
    })->name('admin.users');

    Route::get('/admin/reports', function () {
        return view('admin.reports'); // <-- SUDAH DIFIX
    })->name('admin.reports');
});

// Route bawaan Breeze untuk Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';