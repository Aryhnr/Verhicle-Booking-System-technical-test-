<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingApproval;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApprovalController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $approvals = BookingApproval::with(['booking.vehicle', 'booking.driver', 'approver'])
                ->latest()
                ->paginate(12);
        } else {
            $approvals = BookingApproval::with(['booking.vehicle', 'booking.driver'])
                ->where('approver_id', $user->id)
                ->where('status', 'pending')
                ->latest()
                ->paginate(12);
        }

        return view('approvals.index', compact('approvals'));
    }

    public function show(BookingApproval $approval)
    {
        $approval->load(['booking.vehicle', 'booking.driver', 'booking.createdBy', 'booking.approvals.approver', 'approver']);

        // Cek apakah approver ini boleh aksi sekarang
        $canAct = $approval->approver_id === auth()->id()
            && $approval->status === 'pending'
            && $approval->booking->status !== 'rejected'
            && $approval->booking->status !== 'completed';

        // Khusus level 2, cek level 1 sudah approved
        if ($approval->level === 2) {
            $level1 = $approval->booking->approvals->where('level', 1)->first();
            $canAct = $canAct && $level1?->status === 'approved';
        }

        return view('approvals.show', compact('approval', 'canAct'));
    }

    public function update(Request $request, BookingApproval $approval)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'notes'  => 'nullable|string',
        ]);

        // Pastikan hanya approver yang bersangkutan yang bisa aksi
        if ($approval->approver_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak berwenang melakukan aksi ini.');
        }

        // Pastikan level sebelumnya sudah approved (khusus level 2)
        if ($approval->level === 2) {
            $level1 = $approval->booking->approvals()->where('level', 1)->first();
            if ($level1->status !== 'approved') {
                return redirect()->back()->with('error', 'Menunggu persetujuan level 1 terlebih dahulu.');
            }
        }

        $approval->update([
            'status'      => $validated['status'],
            'notes'       => $validated['notes'],
            'approved_at' => now(),
        ]);

        // Update status booking
        if ($validated['status'] === 'approved') {
            $newStatus = $approval->level === 1 ? 'approved_1' : 'approved_2';
        } else {
            $newStatus = 'rejected';
            // Kembalikan kendaraan & driver jika ditolak
            $approval->booking->vehicle->update(['status' => 'available']);
            $approval->booking->driver->update(['status' => 'available']);
        }

        $approval->booking->update(['status' => $newStatus]);

        $action = $validated['status'] === 'approved'
            ? 'approval.approved_l' . $approval->level
            : 'approval.rejected_l' . $approval->level;

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => $action,
            'model_type'  => 'Booking',
            'model_id'    => $approval->booking_id,
            'description' => 'Booking ' . $approval->booking->booking_code . ' ' . ($validated['status'] === 'approved' ? 'disetujui' : 'ditolak') . ' level ' . $approval->level,
            'ip_address'  => $request->ip(),
        ]);

        Log::channel('activity')->info($action, ['booking_code' => $approval->booking->booking_code]);

        return redirect()->route('approvals.index')->with('success', 'Berhasil.');
    }
}