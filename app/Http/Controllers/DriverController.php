<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drivers = Driver::latest()->paginate(12);
        return view('admin.drivers.index', compact('drivers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.drivers.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name'           => 'required|string|max:100',
            'license_number' => 'required|string|max:50|unique:drivers,license_number',
            'license_type'   => 'required|in:SIM A,SIM B1,SIM B2',
            'phone'          => 'required|string|max:20',
            'status'         => 'required|in:available,on_duty,unavailable',
            'is_active'      => 'sometimes|boolean',
        ], [
            'license_number.unique' => 'Nomor SIM ini sudah terdaftar di sistem.',
            'license_type.in'       => 'Pilih tipe SIM yang valid (SIM A, B1, atau B2).',
        ]);

        Driver::create($validate);
        return redirect()->route('admin.drivers.index')->with('success', 'Driver baru berhasil didaftarkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Driver $driver)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Driver $driver)
    {
        // Mengirimkan objek $driver ke view yang sama dengan form create
        return view('admin.drivers.form', compact('driver'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Driver $driver)
    {
        $validate = $request->validate([
            'name'           => 'required|string|max:100',
            // PENTING: Menambahkan id driver agar validasi unique mengabaikan data milik driver ini sendiri
            'license_number' => 'required|string|max:50|unique:drivers,license_number,' . $driver->id,
            'license_type'   => 'required|in:SIM A,SIM B1,SIM B2',
            'phone'          => 'required|string|max:20',
            'status'         => 'required|in:available,on_duty,unavailable',
            'is_active'      => 'sometimes|boolean',
        ], [
            'license_number.unique' => 'Nomor SIM ini sudah digunakan oleh driver lain.',
        ]);

        $driver->update($validate);
        
        return redirect()->route('admin.drivers.index')->with('success', 'Informasi driver berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver)
    {
        $driver->delete();
        
        return redirect()->route('admin.drivers.index')->with('success', 'Data driver berhasil dihapus dari sistem.');
    }
}
