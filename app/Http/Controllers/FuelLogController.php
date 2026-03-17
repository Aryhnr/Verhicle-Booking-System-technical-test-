<?php

namespace App\Http\Controllers;

use App\Models\FuelLog;
use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class FuelLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fuellogs = FuelLog::with(['booking', 'vehicle'])->latest('date')->paginate(12);
        return view('admin.fuel-logs.index', compact('fuellogs'));
    }

    /**,
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bookings = Booking::where('status', 'completed')->latest()->get();
        $vehicles = Vehicle::where('is_active', true)->get(); // hapus filter status
        return view('admin.fuel-logs.form', compact('bookings', 'vehicles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'vehicle_id'    => 'required|exists:vehicles,id',
            'booking_id'    => 'nullable|exists:bookings,id',
            'date'          => 'required|date',
            'liters'        => 'required|numeric|min:0.1',
            'odometer_km'   => 'required|integer|min:0',
            'cost'          => 'required|numeric|min:0',
            'notes'         => 'nullable|string',
        ]);

        $fuelLog = FuelLog::create(
            $validate
        );
        // ActivityLog::create([
        //     'user_id'     => auth()->id(),
        //     'action'      => 'fuel_log.created',
        //     'model_type'  => 'FuelLog',
        //     'model_id'    => $fuelLog->id,
        //     'description' => 'Log BBM kendaraan ' . $fuelLog->vehicle->plate_number . ' ditambahkan',
        //     'ip_address'  => $request->ip(),
        // ]);

        // Log::channel('activity')->info('fuel_log.created', ['fuel_log_id' => $fuelLog->id]);
        return redirect()->route('admin.fuel-logs.index')->with('success', 'Pemesanan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FuelLog $fuelLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FuelLog $fuelLog)
    {
        $bookings = Booking::where('status', 'completed')->latest()->get();
        $vehicles = Vehicle::where('is_active', true)->get(); // hapus filter status
        return view('admin.fuel-logs.form', compact('fuelLog', 'bookings', 'vehicles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FuelLog $fuelLog)
    {
        $validated = $request->validate([
            'vehicle_id'  => 'required|exists:vehicles,id',
            'booking_id'  => 'nullable|exists:bookings,id',
            'date'        => 'required|date',
            'liters'      => 'required|numeric|min:0.1',
            'odometer_km' => 'required|integer|min:0',
            'cost'        => 'required|numeric|min:0',
            'notes'       => 'nullable|string',
        ]);

        $fuelLog->update($validated);

        // ActivityLog::create([
        //     'user_id'     => auth()->id(),
        //     'action'      => 'fuel_log.updated',
        //     'model_type'  => 'FuelLog',
        //     'model_id'    => $fuelLog->id,
        //     'description' => 'Log BBM kendaraan ' . $fuelLog->vehicle->plate_number . ' diperbarui',
        //     'ip_address'  => $request->ip(),
        // ]);

        return redirect()->route('admin.fuel-logs.index')->with('success', 'Log BBM berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FuelLog $fuelLog)
    {
        // ActivityLog::create([
        //     'user_id'     => auth()->id(),
        //     'action'      => 'fuel_log.deleted',
        //     'model_type'  => 'FuelLog',
        //     'model_id'    => $fuelLog->id,
        //     'description' => 'Log BBM kendaraan ' . $fuelLog->vehicle->plate_number . ' dihapus',
        //     'ip_address'  => request()->ip(),
        // ]);

        $fuelLog->delete();

        return redirect()->route('admin.fuel-logs.index')->with('success', 'Log BBM berhasil dihapus.');
    }
}
