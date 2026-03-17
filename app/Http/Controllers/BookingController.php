<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['vehicle', 'driver', 'createdBy'])->latest()->paginate(12);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $vehicles    = Vehicle::where('status', 'available')->where('is_active', true)->get();
        $drivers     = Driver::where('status', 'available')->where('is_active', true)->get();
        $approversL1 = User::where('role', 'approver')->where('level', 1)->where('is_active', true)->get();
        $approversL2 = User::where('role', 'approver')->where('level', 2)->where('is_active', true)->get();

        return view('admin.bookings.create', compact('vehicles', 'drivers', 'approversL1', 'approversL2'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id'      => 'required|exists:vehicles,id',
            'driver_id'       => 'required|exists:drivers,id',
            'requester_name'  => 'required|string|max:100',
            'purpose'         => 'required|string',
            'destination'     => 'required|string|max:255',
            'start_datetime'  => 'required|date|after:now',
            'end_datetime'    => 'required|date|after:start_datetime',
            'passenger_count' => 'required|integer|min:1',
            'approver_l1'     => 'required|exists:users,id',
            'approver_l2'     => 'required|exists:users,id|different:approver_l1',
            'notes'           => 'nullable|string',
        ]);

        $lastId = Booking::latest('id')->value('id') ?? 0;

        $booking = Booking::create([
            ...$validated,
            'booking_code' => 'BK-' . date('Y') . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT),
            'created_by'   => auth()->id(),
            'status'       => 'pending',
        ]);

        $booking->approvals()->createMany([
            ['approver_id' => $validated['approver_l1'], 'level' => 1, 'status' => 'pending'],
            ['approver_id' => $validated['approver_l2'], 'level' => 2, 'status' => 'pending'],
        ]);

        $booking->vehicle->update(['status' => 'booked']);
        $booking->driver->update(['status' => 'on_duty']);

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'booking.created',
            'model_type'  => 'Booking',
            'model_id'    => $booking->id,
            'description' => 'Booking ' . $booking->booking_code . ' dibuat',
            'ip_address'  => $request->ip(),
        ]);

        Log::channel('activity')->info('booking.created', ['booking_code' => $booking->booking_code]);

        return redirect()->route('admin.bookings.index')->with('success', 'Pemesanan berhasil dibuat.');
    }

    public function show(Booking $booking)
    {
        $booking->load(['vehicle', 'driver', 'createdBy', 'approvals.approver']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        //
    }

    public function update(Request $request, Booking $booking)
    {
        //
    }

    public function complete(Booking $booking)
    {
        if ($booking->status !== 'approved_2') {
            return redirect()->back()->with('error', 'Hanya booking yang sudah disetujui yang bisa diselesaikan.');
        }

        $booking->update([
            'status'     => 'completed',
            'actual_end' => now(),
        ]);

        $booking->vehicle->update(['status' => 'available']);
        $booking->driver->update(['status' => 'available']);

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'booking.completed',
            'model_type'  => 'Booking',
            'model_id'    => $booking->id,
            'description' => 'Booking ' . $booking->booking_code . ' diselesaikan',
            'ip_address'  => request()->ip(),
        ]);

        Log::channel('activity')->info('booking.completed', ['booking_code' => $booking->booking_code]);

        return redirect()->back()->with('success', 'Pemesanan berhasil diselesaikan.');
    }

    public function destroy(Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return redirect()->back()->with('error', 'Pesanan yang sudah diproses tidak dapat dibatalkan.');
        }

        try {
            $booking->vehicle->update(['status' => 'available']);
            $booking->driver->update(['status' => 'available']);
            $booking->approvals()->delete();

            ActivityLog::create([
                'user_id'     => auth()->id(),
                'action'      => 'booking.cancelled',
                'model_type'  => 'Booking',
                'model_id'    => $booking->id,
                'description' => 'Booking ' . $booking->booking_code . ' dibatalkan',
                'ip_address'  => request()->ip(),
            ]);

            Log::channel('activity')->info('booking.cancelled', ['booking_code' => $booking->booking_code]);

            $booking->delete();

            return redirect()->route('admin.bookings.index')->with('success', 'Pesanan berhasil dibatalkan dan armada telah tersedia kembali.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}