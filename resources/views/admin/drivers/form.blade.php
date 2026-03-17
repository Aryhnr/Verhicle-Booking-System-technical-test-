@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-4 mb-8">
        <x-button variant="secondary" :href="route('admin.drivers.index')" class="px-3 py-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </x-button>
        <div>
            <h1 class="text-2xl font-bold text-slate-900">{{ isset($driver) ? 'Edit Profil Driver' : 'Tambah Driver Baru' }}</h1>
            <p class="text-sm text-slate-500 italic">Informasi personal dan lisensi berkendara</p>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
        <form action="{{ isset($driver) ? route('admin.drivers.update', $driver) : route('admin.drivers.store') }}" method="POST" class="p-8 md:p-10">
            @csrf
            @if(isset($driver)) @method('PUT') @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                
                {{-- Nama Lengkap --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest ml-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $driver->name ?? '') }}" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                </div>

                {{-- Nomor Telepon --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest ml-1">Nomor Telepon / WhatsApp</label>
                    <input type="text" name="phone" value="{{ old('phone', $driver->phone ?? '') }}" placeholder="0812..."
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                </div>

                {{-- Tipe Lisensi --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest ml-1">Tipe SIM</label>
                    <select name="license_type" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none">
                        <option value="SIM A" {{ (old('license_type', $driver->license_type ?? '') == 'SIM A') ? 'selected' : '' }}>SIM A</option>
                        <option value="SIM B1" {{ (old('license_type', $driver->license_type ?? '') == 'SIM B1') ? 'selected' : '' }}>SIM B1 (Umum)</option>
                        <option value="SIM B2" {{ (old('license_type', $driver->license_type ?? '') == 'SIM B2') ? 'selected' : '' }}>SIM B2</option>
                    </select>
                </div>

                {{-- Nomor Lisensi --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest ml-1">Nomor SIM</label>
                    <input type="text" name="license_number" value="{{ old('license_number', $driver->license_number ?? '') }}" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none">
                </div>

                {{-- Status --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest ml-1">Ketersediaan</label>
                    <select name="status" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none">
                        <option value="available" {{ (old('status', $driver->status ?? '') == 'available') ? 'selected' : '' }}>Tersedia (Ready)</option>
                        <option value="on_duty" {{ (old('status', $driver->status ?? '') == 'on_duty') ? 'selected' : '' }}>Sedang Bertugas</option>
                        <!-- <option value="unavailable" {{ (old('status', $driver->status ?? '') == 'unavailable') ? 'selected' : '' }}>Tidak Aktif / Libur</option> -->
                    </select>
                </div>

                {{-- Akun Aktif --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest ml-1">Status Kepegawaian</label>
                    <div class="flex items-center gap-4 py-3">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="is_active" value="1" class="hidden peer" {{ old('is_active', $driver->is_active ?? 1) == 1 ? 'checked' : '' }}>
                            <div class="px-4 py-2 rounded-lg border border-slate-200 peer-checked:bg-emerald-50 peer-checked:border-emerald-500 peer-checked:text-emerald-700 text-sm font-bold transition-all">Aktif</div>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="is_active" value="0" class="hidden peer" {{ old('is_active', $driver->is_active ?? 1) == 0 ? 'checked' : '' }}>
                            <div class="px-4 py-2 rounded-lg border border-slate-200 peer-checked:bg-rose-50 peer-checked:border-rose-500 peer-checked:text-rose-700 text-sm font-bold transition-all">Non-Aktif</div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-12 flex items-center justify-end gap-3 bg-slate-50/50 -mx-10 -mb-10 p-6">
                <x-button variant="ghost" :href="route('admin.drivers.index')">Batal</x-button>
                <x-button type="submit" variant="primary" class="px-10">
                    {{ isset($driver) ? 'Simpan Perubahan' : 'Daftarkan Driver' }}
                </x-button>
            </div>
        </form>
    </div>
</div>
@endsection