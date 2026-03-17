@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    {{-- Header & Action --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-4">
            <x-button variant="secondary" :href="route('admin.bookings.index')" class="px-3 py-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </x-button>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Detail Pemesanan</h1>
                <p class="text-sm text-slate-500 font-medium tracking-wide">ID: <span class="text-emerald-600 font-bold uppercase">{{ $booking->booking_code }}</span></p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            @if($booking->status === 'pending')
                <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" onsubmit="return confirm('Batalkan pesanan ini?')">
                    @csrf @method('DELETE')
                    <x-button type="submit" variant="danger">Batalkan Pesanan</x-button>
                </form>
            @endif

            @if($booking->status === 'approved_2')
                <form action="{{ route('admin.bookings.complete', $booking) }}" method="POST" onsubmit="return confirm('Tandai pesanan ini selesai?')">
                    @csrf
                    <x-button type="submit" variant="primary">Tandai Selesai</x-button>
                </form>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Kolom Kiri: Informasi Perjalanan --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-[2.5rem] border border-slate-100 p-8 md:p-10">
                <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-8 border-b border-slate-50 pb-4">Logistik & Destinasi</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Nama Pemohon</label>
                        <p class="text-lg font-bold text-slate-900">{{ $booking->requester_name }}</p>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Tujuan</label>
                        <p class="text-lg font-bold text-slate-900">{{ $booking->destination }}</p>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Waktu Keberangkatan</label>
                        <p class="text-sm font-bold text-slate-700">{{ $booking->start_datetime->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Estimasi Selesai</label>
                        <p class="text-sm font-bold text-slate-700">{{ $booking->end_datetime->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                <div class="mt-10 pt-8 border-t border-slate-50">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Keperluan Perjalanan</label>
                    <p class="text-sm text-slate-600 leading-relaxed italic">"{{ $booking->purpose }}"</p>
                </div>
            </div>

            {{-- Info Kendaraan & Driver --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-100 flex items-center gap-4">
                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-slate-400 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Kendaraan</p>
                        <p class="text-sm font-bold text-slate-800">{{ $booking->vehicle->name }}</p>
                        <p class="text-[11px] text-emerald-600 font-mono font-bold">{{ $booking->vehicle->plate_number }}</p>
                    </div>
                </div>
                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-100 flex items-center gap-4">
                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-slate-400 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Driver</p>
                        <p class="text-sm font-bold text-slate-800">{{ $booking->driver->name }}</p>
                        <p class="text-[11px] text-slate-500 font-medium italic">{{ $booking->driver->phone }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Status Approval --}}
        <div class="space-y-6">
            <div class="bg-emerald-900 rounded-[2.5rem] p-8 text-white shadow-xl shadow-emerald-100/20">
                <h3 class="text-[10px] font-bold text-emerald-400 uppercase tracking-[0.2em] mb-8 border-b border-emerald-800 pb-4 text-center">Status Persetujuan</h3>
                
                <div class="space-y-10 relative">
                    {{-- Garis Penghubung --}}
                    <div class="absolute left-[19px] top-2 bottom-2 w-0.5 bg-emerald-800"></div>

                    @foreach($booking->approvals as $approval)
                        <div class="flex gap-6 relative z-10">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center border-4 border-emerald-900 
                                {{ $approval->status === 'approved' ? 'bg-emerald-400 text-emerald-950' : ($approval->status === 'rejected' ? 'bg-rose-500 text-white' : 'bg-emerald-800 text-emerald-400') }}">
                                @if($approval->status === 'approved')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                @elseif($approval->status === 'rejected')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                @else
                                    <span class="text-xs font-bold">{{ $approval->level }}</span>
                                @endif
                            </div>
                            <div class="flex-1 pt-1">
                                <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest mb-1">Tingkat {{ $approval->level }}</p>
                                <p class="text-sm font-bold text-white">{{ $approval->approver->name }}</p>
                                <p class="text-[11px] text-emerald-300/60 italic">{{ $approval->approver->department ?? 'Manajemen' }}</p>
                                
                                <div class="mt-3">
                                    <span class="inline-flex px-2 py-0.5 rounded-md text-[9px] font-bold uppercase tracking-wider 
                                        {{ $approval->status === 'approved' ? 'bg-emerald-400/20 text-emerald-400' : ($approval->status === 'rejected' ? 'bg-rose-400/20 text-rose-300' : 'bg-white/10 text-emerald-200') }}">
                                        {{ $approval->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12 pt-8 border-t border-emerald-800 text-center">
                    <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest mb-1">Status Akhir</p>
                    <p class="text-xl font-black text-white uppercase tracking-tighter">{{ $booking->status }}</p>
                </div>
            </div>

            <div class="bg-slate-50 rounded-[2rem] p-6 border border-slate-100">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Dibuat Oleh</p>
                <p class="text-sm font-bold text-slate-800">{{ $booking->createdBy->name ?? 'System' }}</p>
                <p class="text-[10px] text-slate-400">{{ $booking->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection