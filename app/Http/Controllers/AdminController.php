<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scan;
use App\Models\User;
use App\Models\AuditLog;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalScans = Scan::count();
        $totalRejected = Scan::where('status', 'rejected')->count();
        $recentLogs = AuditLog::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalUsers', 'totalScans', 'totalRejected', 'recentLogs'));
    }

    public function monitoring()
    {
        $scans = Scan::with('user')->latest()->get();
        return view('admin.monitoring', compact('scans'));
    }

    public function users()
    {
        $users = User::where('role', 'user')->latest()->get();
        return view('admin.users', compact('users'));
    }

    public function exportCsv()
    {
        // Hanya export data yang SUKSES, DISETUJUI USER (consent), dan punya LABEL
        $scans = Scan::where('status', 'success')
                    ->where('consent_training', true)
                    ->whereNotNull('cnn_label')
                    ->get();

        $filename = 'dataset_healthcare_' . date('Ymd_His') . '.csv';

        // Gunakan stream untuk efisiensi memori
        return response()->streamDownload(function () use ($scans) {
            $handle = fopen('php://output', 'w');

            // Header CSV (Kolom-kolom yang dibutuhkan untuk training)
            fputcsv($handle, ['scan_id', 'image_filename', 'label', 'confidence_score', 'created_at']);

            foreach ($scans as $scan) {
                fputcsv($handle, [
                    $scan->id,
                    basename($scan->image_path), // Ambil nama filenya saja
                    $scan->cnn_label,
                    $scan->confidence_score,
                    $scan->created_at,
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}