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

    // Dashboard (Dinamis)
    Route::get('/dashboard', function () {
        /** @var \App\Models\User $user */ //
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

    // Route untuk memproses upload
    Route::post('/scan', [ScanController::class, 'store'])->name('scan.store');

    // Chat & Riwayat
    Route::get('/chat/{scan?}', function (\App\Models\Scan $scan = null) {
        return view('chat', ['scan' => $scan]);
    })->name('chat.index');

    // Endpoint untuk kirim pesan chat (HANYA INI YANG DIPAKAI)
    Route::post('/chat/{scan}/send', [ChatController::class, 'send'])->name('chat.send');

    // 2. HAPUS ROUTE POST /chat YANG KEDUA (Yang duplikat)

    // History (Dinamis)
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
});

// Route bawaan Breeze untuk Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';