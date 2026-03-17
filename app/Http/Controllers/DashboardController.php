<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\BookingApproval;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $data = [
                'total_vehicles'  => Vehicle::where('is_active', true)->count(),
                'total_drivers'   => Driver::where('is_active', true)->count(),
                'total_bookings'  => Booking::whereMonth('created_at', now()->month)->count(),
                'pending_count'   => Booking::where('status', 'pending')->count(),
                'recent_bookings' => Booking::with(['vehicle', 'driver'])->latest()->take(5)->get(),
                'chart_data'      => $this->getChartData(),
            ];
        } else {
            $data = [
                'pending_count'   => BookingApproval::where('approver_id', $user->id)->where('status', 'pending')->count(),
                'recent_approvals'=> BookingApproval::with(['booking.vehicle', 'booking.driver'])
                                        ->where('approver_id', $user->id)
                                        ->where('status', 'pending')
                                        ->latest()
                                        ->take(5)
                                        ->get(),
            ];
        }

        return view('dashboard.index', compact('data'));
    }

    private function getChartData(): array
    {
        $months = collect(range(1, 12))->map(fn($m) => [
            'month' => $m,
            'label' => now()->month($m)->format('M'),
            'total' => Booking::whereYear('created_at', now()->year)
                            ->whereMonth('created_at', $m)
                            ->count(),
        ]);

        return [
            'labels' => $months->pluck('label'),
            'totals' => $months->pluck('total'),
        ];
    }
}