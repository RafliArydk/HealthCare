<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $user = Auth::user();

        $totalScans = $user->scans()->count();
        $scanObat = $user->scans()->where('type', 'obat')->count();
        $scanLuka = $user->scans()->where('type', 'luka')->count();
        $recentScans = $user->scans()->latest()->take(3)->get();
        $latestScan = $user->scans()->latest()->first();

        return view('dashboard', compact('totalScans', 'scanObat', 'scanLuka', 'recentScans', 'latestScan'));
    }
}
