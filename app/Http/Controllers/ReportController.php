<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BookingExport;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['vehicle', 'driver', 'createdBy', 'approvals.approver']);

        // Filter bulan & tahun
        if ($request->month && $request->year) {
            $query->whereMonth('created_at', $request->month)
                  ->whereYear('created_at', $request->year);
        } elseif ($request->year) {
            $query->whereYear('created_at', $request->year);
        } else {
            // Default: bulan ini
            $query->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
        }

        $bookings = $query->latest()->paginate(15)->withQueryString();

        // Summary
        $summary = [
            'total'      => $query->count(),
            'pending'    => (clone $query)->where('status', 'pending')->count(),
            'approved'   => (clone $query)->where('status', 'approved_2')->count(),
            'rejected'   => (clone $query)->where('status', 'rejected')->count(),
            'completed'  => (clone $query)->where('status', 'completed')->count(),
        ];

        $years  = Booking::selectRaw('YEAR(created_at) as year')->distinct()->pluck('year');
        $months = collect(range(1, 12))->map(fn($m) => [
            'value' => $m,
            'label' => now()->month($m)->format('F'),
        ]);

        return view('admin.reports.index', compact('bookings', 'summary', 'years', 'months'));
    }

    public function export(Request $request)
    {
        $filename = 'laporan-booking-' . ($request->month ?? 'all') . '-' . ($request->year ?? now()->year) . '.xlsx';

        return Excel::download(new BookingExport($request->month, $request->year), $filename);
    }
}