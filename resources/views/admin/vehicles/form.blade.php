@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Header --}}
    <div class="flex items-center gap-4 mb-8">
        <x-button variant="secondary" :href="route('admin.vehicles.index')" class="px-3 py-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </x-button>
        <div>
            <h1 class="text-2xl font-bold text-slate-900">{{ isset($vehicle) ? 'Edit Kendaraan' : 'Tambah Kendaraan Baru' }}</h1>
            <p class="text-sm text-slate-500 italic">Lengkapi detail informasi armada RS Delta Surya</p>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
        <form action="{{ isset($vehicle) ? route('admin.vehicles.update', ['vehicle' => $vehicle->id]) : route('admin.vehicles.store') }}" method="POST" class="p-8 md:p-10">
            @csrf
            @if(isset($vehicle)) @method('PUT') @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                
                {{-- Nama Kendaraan --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest ml-1">Nama Kendaraan</label>
                    <input type="text" name="name" value="{{ old('name', $vehicle->name ?? '') }}" placeholder="Contoh: Ambulans Toyota Hiace" 
                        class="w-full px-4 py-3 rounded-xl border {{ $errors->has('name') ? 'border-rose-500' : 'border-slate-200' }} focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                    @error('name') <p class="text-[10px] text-rose-500 font-bold ml-1 uppercase tracking-tight">{{ $message }}</p> @enderror
                </div>

                {{-- Nomor Plat --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest ml-1">Nomor Plat (Nopol)</label>
                    <input type="text" name="plate_number" value="{{ old('plate_number', $vehicle->plate_number ?? '') }}" placeholder="W 1234 AB"
                        class="w-full px-4 py-3 rounded-xl border {{ $errors->has('plate_number') ? 'border-rose-500' : 'border-slate-200' }} focus:ring-2 focus:ring-emerald-400 outline-none transition-all uppercase">
                    @error('plate_number') <p class="text-[10px] text-rose-500 font-bold ml-1 uppercase tracking-tight">{{ $message }}</p> @enderror
                </div>

                {{-- Tipe Kendaraan (Disesuaikan dengan Controller: passenger/cargo) --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest ml-1">Tipe Kendaraan</label>
                    <select name="type" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                        <option value="passenger" {{ old('type', $vehicle->type ?? '') == 'passenger' ? 'selected' : '' }}>Angkutan Orang (Passenger)</option>
                        <option value="cargo" {{ old('type', $vehicle->type ?? '') == 'cargo' ? 'selected' : '' }}>Angkutan Barang (Cargo)</option>
                    </select>
                </div>

                {{-- Kepemilikan (Disesuaikan dengan Controller: owned/rented) --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest ml-1">Kepemilikan</label>
                    <select name="ownership" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                        <option value="owned" {{ old('ownership', $vehicle->ownership ?? '') == 'owned' ? 'selected' : '' }}>Milik Perusahaan (Owned)</option>
                        <option value="rented" {{ old('ownership', $vehicle->ownership ?? '') == 'rented' ? 'selected' : '' }}>Sewa / Vendor (Rented)</option>
                    </select>
                </div>

                {{-- Kapasitas & Bahan Bakar --}}
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest ml-1">Kapasitas</label>
                        <input type="number" name="capacity" value="{{ old('capacity', $vehicle->capacity ?? '') }}" placeholder="0" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest ml-1">BBM</label>
                        <input type="text" name="fuel_type" value="{{ old('fuel_type', $vehicle->fuel_type ?? '') }}" placeholder="Pertalite/Solar" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none">
                    </div>
                </div>

                {{-- Status Kendaraan (Wajib di Controller) --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest ml-1">Kondisi Saat Ini</label>
                    <select name="status" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                        <option value="available" {{ old('status', $vehicle->status ?? '') == 'available' ? 'selected' : '' }}>Tersedia (Available)</option>
                        <option value="booked" {{ old('status', $vehicle->status ?? '') == 'booked' ? 'selected' : '' }}>Sedang Digunakan (Booked)</option>
                        <option value="maintenance" {{ old('status', $vehicle->status ?? '') == 'maintenance' ? 'selected' : '' }}>Perbaikan (Maintenance)</option>
                    </select>
                </div>

                {{-- Status Aktif (Toggle) --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest ml-1">Status Akun</label>
                    <div class="flex items-center gap-4 py-3">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="is_active" value="1" class="hidden peer" {{ old('is_active', $vehicle->is_active ?? 1) == 1 ? 'checked' : '' }}>
                            <div class="px-4 py-2 rounded-lg border border-slate-200 peer-checked:bg-emerald-50 peer-checked:border-emerald-500 peer-checked:text-emerald-700 text-sm font-bold transition-all">Aktif</div>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="is_active" value="0" class="hidden peer" {{ old('is_active', $vehicle->is_active ?? 1) == 0 ? 'checked' : '' }}>
                            <div class="px-4 py-2 rounded-lg border border-slate-200 peer-checked:bg-rose-50 peer-checked:border-rose-500 peer-checked:text-rose-700 text-sm font-bold transition-all">Non-Aktif</div>
                        </label>
                    </div>
                </div>

                <hr class="md:col-span-2 border-slate-100 my-2">

                {{-- Tanggal Service --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest ml-1">Service Terakhir</label>
                    <input type="date" name="last_service_date" value="{{ old('last_service_date', isset($vehicle) && $vehicle->last_service_date ? $vehicle->last_service_date->format('Y-m-d') : '') }}" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none">
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest ml-1">Service Berikutnya</label>
                    <input type="date" name="next_service_date" value="{{ old('next_service_date', isset($vehicle) && $vehicle->next_service_date ? $vehicle->next_service_date->format('Y-m-d') : '') }}" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none">
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="mt-12 flex items-center justify-end gap-3 bg-slate-50/50 -mx-10 -mb-10 p-6">
                <x-button variant="ghost" :href="route('admin.vehicles.index')">Batal</x-button>
                <x-button type="submit" variant="primary" class="px-10">
                    {{ isset($vehicle) ? 'Simpan Perubahan' : 'Daftarkan Kendaraan' }}
                </x-button>
            </div>
        </form>
    </div>
</div>
@endsection