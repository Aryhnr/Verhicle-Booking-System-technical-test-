@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    {{-- Header --}}
    <div class="flex items-center gap-4 mb-8">
        <x-button variant="secondary" :href="route('admin.bookings.index')" class="px-3 py-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </x-button>
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Buat Pemesanan Baru</h1>
            <p class="text-sm text-slate-500 italic">Formulir pengajuan peminjaman armada & driver</p>
        </div>
    </div>

    <form action="{{ route('admin.bookings.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Bagian Utama --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-8 md:p-10 space-y-6">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-widest border-b border-slate-50 pb-4">Informasi Perjalanan</h3>
                    
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest ml-1">Nama Pemohon</label>
                        <input type="text" name="requester_name" value="{{ old('requester_name') }}" placeholder="Contoh: Unit Gawat Darurat" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest ml-1">Tujuan</label>
                            <input type="text" name="destination" value="{{ old('destination') }}" placeholder="Lokasi tujuan..." 
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest ml-1">Jumlah Penumpang</label>
                            <input type="number" name="passenger_count" value="{{ old('passenger_count') }}" 
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest ml-1">Keperluan</label>
                        <textarea name="purpose" rows="3" placeholder="Jelaskan detail keperluan..." 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">{{ old('purpose') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest ml-1">Waktu Berangkat</label>
                            <input type="datetime-local" name="start_datetime" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest ml-1">Estimasi Kembali</label>
                            <input type="datetime-local" name="end_datetime" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar Approval & Asset --}}
            <div class="space-y-6">
                {{-- Asset Selection --}}
                <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-6 space-y-5">
                    <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] border-b border-slate-50 pb-2">Aset & Driver</h3>
                    
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-700 uppercase">Pilih Kendaraan</label>
                        <select name="vehicle_id" class="w-full px-3 py-2 rounded-lg border border-slate-100 bg-slate-50 text-sm outline-none">
                            @foreach($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}">{{ $vehicle->name }} ({{ $vehicle->plate_number }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-700 uppercase">Pilih Driver</label>
                        <select name="driver_id" class="w-full px-3 py-2 rounded-lg border border-slate-100 bg-slate-50 text-sm outline-none">
                            @foreach($drivers as $driver)
                                <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Approvers Section --}}
                <div class="bg-emerald-900 rounded-[2.5rem] p-8 text-white space-y-6">
                    <div class="space-y-1 text-center">
                        <h3 class="text-[10px] font-bold text-emerald-400 uppercase tracking-[0.3em]">Otoritas Persetujuan</h3>
                        <div class="h-px w-8 bg-emerald-500/30 mx-auto"></div>
                    </div>
                    
                    <div class="space-y-5 pt-2">
                        {{-- Level 1 --}}
                        <div class="group">
                            <label class="block text-[10px] font-bold text-emerald-300 uppercase tracking-widest mb-2 ml-1 opacity-80 group-focus-within:opacity-100 transition-opacity">
                                Approval Tingkat 1
                            </label>
                            <select name="approver_l1" 
                                class="w-full px-4 py-3 rounded-2xl bg-emerald-800/40 border border-emerald-700/50 text-sm text-emerald-50 focus:bg-emerald-800/80 focus:ring-2 focus:ring-emerald-400/50 focus:border-emerald-400 outline-none transition-all cursor-pointer">
                                <option value="" class="bg-emerald-900">-- Pilih Approver --</option>
                                @foreach($approversL1 as $user)
                                    <option value="{{ $user->id }}" class="bg-emerald-900 text-white">
                                        {{ $user->name }} — {{ $user->department }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Level 2 --}}
                        <div class="group">
                            <label class="block text-[10px] font-bold text-emerald-300 uppercase tracking-widest mb-2 ml-1 opacity-80 group-focus-within:opacity-100 transition-opacity">
                                Approval Tingkat 2
                            </label>
                            <select name="approver_l2" 
                                class="w-full px-4 py-3 rounded-2xl bg-emerald-800/40 border border-emerald-700/50 text-sm text-emerald-50 focus:bg-emerald-800/80 focus:ring-2 focus:ring-emerald-400/50 focus:border-emerald-400 outline-none transition-all cursor-pointer">
                                <option value="" class="bg-emerald-900">-- Pilih Approver --</option>
                                @foreach($approversL2 as $user)
                                    <option value="{{ $user->id }}" class="bg-emerald-900 text-white">
                                        {{ $user->name }} — {{ $user->department }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Action --}}
                    <div class="pt-6">
                        <x-button type="submit" variant="primary" 
                            class="w-full justify-center bg-emerald-400 text-emerald-950 hover:bg-white hover:scale-[1.02] active:scale-95 border-none py-4 rounded-2xl font-bold transition-all duration-300">
                            Kirim Pengajuan
                        </x-button>
                        <p class="text-[9px] text-emerald-400/60 text-center mt-4 italic font-medium">
                            Pastikan data perjalanan sudah sesuai sebelum mengirim.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection