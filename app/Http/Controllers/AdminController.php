<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Chat;
use App\Models\Scan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalScans = Scan::count();
        $totalRejected = Scan::where('status', 'rejected')->count();
        $totalChats = Chat::count();
        $recentLogs = AuditLog::with('user')->latest()->take(5)->get();
        $dailyActivity = $this->dailyActivity();
        $distribution = [
            'obat' => Scan::where('type', 'obat')->count(),
            'luka' => Scan::where('type', 'luka')->count(),
            'chat' => $totalChats,
        ];

        return view('admin.dashboard', compact('totalUsers', 'totalScans', 'totalRejected', 'totalChats', 'dailyActivity', 'distribution', 'recentLogs'));
    }

    public function monitoring(Request $request)
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
            'status' => ['nullable', 'in:accepted,rejected'],
        ]);
        $query = Scan::with('user')->latest();
        $this->applyScanFilters($query, $filters);
        $scans = $query->paginate(20)->withQueryString();
        $totalScans = Scan::count();
        $successfulScans = Scan::where('status', 'accepted')->count();
        $rejectedScans = Scan::where('status', 'rejected')->count();
        $activeChats = Chat::where('created_at', '>=', now()->subMinutes(30))->count();

        return view('admin.monitoring', compact('scans', 'totalScans', 'successfulScans', 'rejectedScans', 'activeChats', 'filters'));
    }

    public function users(Request $request)
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'from' => ['nullable', 'date'],
        ]);
        $query = User::where('role', 'user')->latest();
        if (! empty($filters['search'])) {
            $query->where(function ($builder) use ($filters) {
                $builder->where('name', 'like', '%'.$filters['search'].'%')
                    ->orWhere('email', 'like', '%'.$filters['search'].'%');
            });
        }
        if (! empty($filters['from'])) {
            $query->whereDate('created_at', '>=', $filters['from']);
        }
        $users = $query->paginate(20)->withQueryString();
        $totalUsers = User::where('role', 'user')->count();
        $activeUsers = User::where('role', 'user')->where('updated_at', '>=', now()->subDays(30))->count();
        $newUsers = User::where('role', 'user')->where('created_at', '>=', now()->subDays(7))->count();

        return view('admin.users', compact('users', 'totalUsers', 'activeUsers', 'newUsers', 'filters'));
    }

    public function reports(Request $request)
    {
        $filters = $request->validate([
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
        ]);
        $scans = Scan::query();
        $this->applyDateFilters($scans, $filters);
        $totalActivities = (clone $scans)->count() + Chat::query()->when($filters['from'] ?? null, fn ($q, $from) => $q->whereDate('created_at', '>=', $from))->when($filters['to'] ?? null, fn ($q, $to) => $q->whereDate('created_at', '<=', $to))->count();
        $accepted = (clone $scans)->where('status', 'accepted')->count();
        $rejected = (clone $scans)->where('status', 'rejected')->count();
        $distribution = [
            'obat' => (clone $scans)->where('type', 'obat')->count(),
            'luka' => (clone $scans)->where('type', 'luka')->count(),
        ];
        $dailyActivity = $this->dailyActivity($filters);

        return view('admin.reports', compact('totalActivities', 'accepted', 'rejected', 'distribution', 'dailyActivity', 'filters'));
    }

    public function exportCsv(Request $request)
    {
        $filters = $request->validate([
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
        ]);
        $scans = Scan::whereIn('status', ['accepted', 'success'])
            ->where('consent_training', true)
            ->whereNotNull('cnn_label')
            ->when($filters['from'] ?? null, fn ($query, $from) => $query->whereDate('created_at', '>=', $from))
            ->when($filters['to'] ?? null, fn ($query, $to) => $query->whereDate('created_at', '<=', $to))
            ->orderBy('id');

        $filename = 'dataset_healthcare_'.date('Ymd_His').'.csv';

        // Gunakan stream untuk efisiensi memori
        return response()->streamDownload(function () use ($scans) {
            $handle = fopen('php://output', 'w');

            // Header CSV (Kolom-kolom yang dibutuhkan untuk training)
            fputcsv($handle, ['scan_id', 'image_filename', 'label', 'confidence_score', 'created_at']);

            foreach ($scans->cursor() as $scan) {
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
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }

    private function applyScanFilters($query, array $filters): void
    {
        if (! empty($filters['search'])) {
            $query->where(function ($builder) use ($filters) {
                $builder->where('cnn_label', 'like', '%'.$filters['search'].'%')
                    ->orWhere('type', 'like', '%'.$filters['search'].'%')
                    ->orWhereHas('user', fn ($user) => $user->where('name', 'like', '%'.$filters['search'].'%')->orWhere('email', 'like', '%'.$filters['search'].'%'));
            });
        }
        $this->applyDateFilters($query, $filters);
        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
    }

    private function applyDateFilters($query, array $filters): void
    {
        $query->when($filters['from'] ?? null, fn ($builder, $from) => $builder->whereDate('created_at', '>=', $from))
            ->when($filters['to'] ?? null, fn ($builder, $to) => $builder->whereDate('created_at', '<=', $to));
    }

    private function dailyActivity(array $filters = []): array
    {
        $end = isset($filters['to']) ? Carbon::parse($filters['to'])->endOfDay() : Carbon::today()->endOfDay();
        $start = isset($filters['from']) ? Carbon::parse($filters['from'])->startOfDay() : $end->copy()->subDays(6)->startOfDay();
        if (! isset($filters['from']) && isset($filters['to'])) {
            $start = $end->copy()->subDays(6)->startOfDay();
        }

        $scans = Scan::query()
            ->selectRaw('DATE(created_at) as activity_date, COUNT(*) as total')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('activity_date')
            ->pluck('total', 'activity_date');
        $chats = Chat::query()
            ->selectRaw('DATE(created_at) as activity_date, COUNT(*) as total')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('activity_date')
            ->pluck('total', 'activity_date');

        return collect(Carbon::parse($start->toDateString())->daysUntil($end->copy()->addDay()->toDateString()))
            ->map(fn (Carbon $date): array => [
                'label' => $date->format('D'),
                'date' => $date->toDateString(),
                'scans' => (int) ($scans[$date->toDateString()] ?? 0),
                'chats' => (int) ($chats[$date->toDateString()] ?? 0),
            ])->all();
    }
}
