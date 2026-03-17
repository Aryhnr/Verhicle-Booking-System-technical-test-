<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::latest()->paginate(12);
        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('admin.vehicles.form');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'plate_number'      => 'required|string|max:20|unique:vehicles,plate_number',
            'name'              => 'required|string|max:100',
            'type'              => 'required|in:passenger,cargo',
            'ownership'         => 'required|in:owned,rented',
            'capacity'          => 'required|integer|min:1',
            'status'            => 'required|in:available,booked,maintenance',
            'fuel_type'         => 'required|string|max:20',
            'last_service_date' => 'nullable|date',
            'next_service_date' => 'nullable|date|after_or_equal:last_service_date',
            'is_active'         => 'sometimes|boolean', // Gunakan sometimes karena checkbox sering tidak terkirim jika tidak dicentang
        ]);

        Vehicle::create($validate);
        return redirect()->route('admin.vehicles.index')->with('success', 'Kendaraan baru berhasil didaftarkan.');
    }

    public function edit(Vehicle $vehicle)
    {
        // Menggunakan Route Model Binding (otomatis mencari berdasarkan ID)
        return view('admin.vehicles.form', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validate = $request->validate([
            // PENTING: Tambahkan ignore ID pada unique agar tidak error saat update data yang sama
            'plate_number'      => 'required|string|max:20|unique:vehicles,plate_number,' . $vehicle->id,
            'name'              => 'required|string|max:100',
            'type'              => 'required|in:passenger,cargo',
            'ownership'         => 'required|in:owned,rented',
            'capacity'          => 'required|integer|min:1',
            'status'            => 'required|in:available,booked,maintenance',
            'fuel_type'         => 'required|string|max:20',
            'last_service_date' => 'nullable|date',
            'next_service_date' => 'nullable|date|after_or_equal:last_service_date',
            'is_active'         => 'sometimes|boolean',
        ]);

        $vehicle->update($validate);
        return redirect()->route('admin.vehicles.index')->with('success', 'Data kendaraan berhasil diperbarui.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('admin.vehicles.index')->with('success', 'Kendaraan berhasil dihapus dari sistem.');
    }
}