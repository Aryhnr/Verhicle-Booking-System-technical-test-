@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-4 mb-8">
        <x-button variant="secondary" :href="route('admin.fuel-logs.index')" class="px-3 py-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </x-button>
        <div>
            <h1 class="text-2xl font-bold text-slate-900">{{ isset($fuelLog) ? 'Edit Log BBM' : 'Catat Pengisian BBM' }}</h1>
            <p class="text-sm text-slate-500 italic">Dokumentasi biaya operasional kendaraan</p>
        </div>
    </div>

    <form action="{{ isset($fuelLog) ? route('admin.fuel-logs.update', $fuelLog) : route('admin.fuel-logs.store') }}" method="POST">
        @csrf
        @if(isset($fuelLog)) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-[2.5rem] border border-slate-100 p-8 space-y-6">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-50 pb-4">Data Pengisian</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-widest ml-1">Tanggal</label>
                            <input type="date" name="date" value="{{ old('date', isset($fuelLog) ? $fuelLog->date->format('Y-m-d') : date('Y-m-d')) }}" 
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-widest ml-1">Odometer (KM)</label>
                            <input type="number" name="odometer_km" value="{{ old('odometer_km', $fuelLog->odometer_km ?? '') }}" placeholder="0" 
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-widest ml-1">Jumlah (Liter)</label>
                            <input type="number" step="0.01" name="liters" value="{{ old('liters', $fuelLog->liters ?? '') }}" placeholder="0.00" 
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-widest ml-1">Total Biaya (Rp)</label>
                            <input type="number" name="cost" value="{{ old('cost', $fuelLog->cost ?? '') }}" placeholder="Rp" 
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-widest ml-1">Catatan Tambahan</label>
                        <textarea name="notes" rows="3" placeholder="Contoh: Pengisian Pertamax di SPBU 54..." 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none">{{ old('notes', $fuelLog->notes ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-emerald-900 rounded-[2.5rem] p-8 text-white space-y-6">
                    <h3 class="text-[10px] font-bold text-emerald-400 uppercase tracking-[0.2em] border-b border-emerald-800 pb-2 text-center">Relasi Asset</h3>
                    
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-emerald-200 uppercase ml-1">Pilih Kendaraan</label>
                        <select name="vehicle_id" class="w-full px-4 py-3 rounded-2xl bg-emerald-800/40 border border-emerald-700/50 text-sm text-emerald-50 outline-none">
                            <option value="" class="bg-emerald-900">-- Pilih Armada --</option>
                            @foreach($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}" {{ (old('vehicle_id', $fuelLog->vehicle_id ?? '') == $vehicle->id) ? 'selected' : '' }} class="bg-emerald-900">
                                    {{ $vehicle->name }} ({{ $vehicle->plate_number }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-emerald-200 uppercase ml-1">Terkait Booking (Opsional)</label>
                        <select name="booking_id" class="w-full px-4 py-3 rounded-2xl bg-emerald-800/40 border border-emerald-700/50 text-sm text-emerald-50 outline-none">
                            <option value="" class="bg-emerald-900">-- Tanpa Booking --</option>
                            @foreach($bookings as $booking)
                                <option value="{{ $booking->id }}" {{ (old('booking_id', $fuelLog->booking_id ?? '') == $booking->id) ? 'selected' : '' }} class="bg-emerald-900">
                                    {{ $booking->booking_code }} - {{ $booking->destination }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="pt-4">
                        <x-button type="submit" variant="primary" class="w-full justify-center bg-emerald-400 text-emerald-950 hover:bg-white border-none py-4">
                            {{ isset($fuelLog) ? 'Simpan Perubahan' : 'Simpan Log BBM' }}
                        </x-button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection