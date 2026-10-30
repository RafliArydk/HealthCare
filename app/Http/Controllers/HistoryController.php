<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class HistoryController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $this->validatedFilters($request);
        $query = Auth::user()->scans()->latest();

        if (! empty($filters['search'])) {
            $query->where(function ($builder) use ($filters): void {
                $builder->where('type', 'like', '%'.$filters['search'].'%')
                    ->orWhere('cnn_label', 'like', '%'.$filters['search'].'%')
                    ->orWhere('initial_analysis', 'like', '%'.$filters['search'].'%');
            });
        }

        $query->when($filters['from'] ?? null, fn ($builder, $from) => $builder->whereDate('created_at', '>=', $from))
            ->when($filters['to'] ?? null, fn ($builder, $to) => $builder->whereDate('created_at', '<=', $to))
            ->when($filters['type'] ?? null, fn ($builder, $type) => $builder->where('type', $type))
            ->when($filters['status'] ?? null, fn ($builder, $status) => $builder->where('status', $status));

        return view('history', [
            'scans' => $query->paginate(15)->withQueryString(),
            'filters' => $filters,
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $filters = $this->validatedFilters($request, false);
        $query = Auth::user()->scans()->latest()
            ->when($filters['from'] ?? null, fn ($builder, $from) => $builder->whereDate('created_at', '>=', $from))
            ->when($filters['to'] ?? null, fn ($builder, $to) => $builder->whereDate('created_at', '<=', $to))
            ->when($filters['type'] ?? null, fn ($builder, $type) => $builder->where('type', $type))
            ->when($filters['status'] ?? null, fn ($builder, $status) => $builder->where('status', $status));

        return response()->streamDownload(function () use ($query): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['scan_id', 'type', 'cnn_label', 'confidence', 'status', 'created_at']);

            foreach ($query->cursor() as $scan) {
                fputcsv($handle, [$scan->id, $scan->type, $scan->cnn_label, $scan->confidence_score, $scan->status, $scan->created_at]);
            }

            fclose($handle);
        }, 'riwayat-scan-'.now()->format('Ymd_His').'.csv', ['Content-Type' => 'text/csv']);
    }

    private function validatedFilters(Request $request, bool $includeSearch = true): array
    {
        $rules = [
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
            'type' => ['nullable', 'in:obat,luka'],
            'status' => ['nullable', 'in:accepted,rejected'],
        ];

        if ($includeSearch) {
            $rules['search'] = ['nullable', 'string', 'max:100'];
        }

        return $request->validate($rules);
    }
}
