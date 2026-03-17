@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    {{-- Header & Back Button --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('approvals.index') }}" class="w-10 h-10 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Review Persetujuan</h1>
                <p class="text-sm text-slate-500 mt-1 uppercase tracking-widest font-mono text-[10px]">{{ $approval->booking->booking_code }}</p>
            </div>
        </div>
        <div class="hidden md:flex items-center gap-2">
            <span class="text-[9px] font-black uppercase px-3 py-1.5 bg-slate-100 text-slate-500 rounded-lg tracking-widest border border-slate-200">
                Otorisasi Tingkat {{ $approval->level }}
            </span>
            @if($approval->status !== 'pending')
                <span class="text-[9px] font-black uppercase px-3 py-1.5 {{ $approval->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }} rounded-lg tracking-widest border {{ $approval->status === 'approved' ? 'border-emerald-200' : 'border-rose-200' }}">
                    Status: {{ $approval->status }}
                </span>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

        {{-- KIRI: Detail Pemesanan --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-[2.5rem] border border-slate-100 p-8 shadow-sm">
                <h3 class="text-[10px] font-bold text-emerald-600 uppercase tracking-[0.2em] border-b border-emerald-50 pb-4 mb-6">Detail Rencana Perjalanan</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Tujuan / Keperluan</p>
                            <p class="text-sm font-bold text-slate-800">{{ $approval->booking->destination }}</p>
                            <p class="text-xs text-slate-500 mt-2">{{ $approval->booking->purpose }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Tanggal Mulai</p>
                            <p class="text-sm font-bold text-slate-800">{{ $approval->booking->start_datetime->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Pemohon (Dibuat Oleh)</p>
                            <p class="text-sm font-bold text-slate-800">{{ $approval->booking->createdBy->name ?? 'Sistem' }}</p>
                            <p class="text-xs text-slate-500 font-mono">{{ $approval->booking->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Estimasi Kembali</p>
                            <p class="text-sm font-bold text-slate-800">{{ $approval->booking->end_datetime->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Kendaraan --}}
                <div class="bg-white rounded-[2rem] border border-slate-100 p-6 shadow-sm">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kendaraan</p>
                            <p class="text-sm font-bold text-slate-800 truncate">{{ $approval->booking->vehicle->name }}</p>
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3 flex justify-between items-center">
                        <span class="text-xs text-slate-500">Nomor Plat</span>
                        <span class="text-xs font-mono font-bold text-emerald-600">{{ $approval->booking->vehicle->plate_number }}</span>
                    </div>
                </div>

                {{-- Driver --}}
                <div class="bg-white rounded-[2rem] border border-slate-100 p-6 shadow-sm">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pengemudi</p>
                            <p class="text-sm font-bold text-slate-800">{{ $approval->booking->driver->name ?? 'Tanpa Pengemudi' }}</p>
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3 flex justify-between items-center">
                        <span class="text-xs text-slate-500">Kontak</span>
                        <span class="text-xs font-mono font-bold text-slate-600">{{ $approval->booking->driver->phone ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- KANAN: Panel Keputusan --}}
        <div class="lg:col-span-1 lg:sticky lg:top-8">
            <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-xl shadow-slate-900/20">
                <h3 class="text-[10px] font-bold text-emerald-400 uppercase tracking-[0.2em] border-b border-slate-800 pb-4 mb-6 text-center">Formulir Keputusan</h3>

                @if($canAct)
                    <form action="{{ route('approvals.update', $approval->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="space-y-2">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Catatan (Opsional)</label>
                            <textarea name="notes" rows="4" placeholder="Alasan disetujui/ditolak..."
                                class="w-full px-4 py-3 rounded-2xl bg-slate-800 border border-slate-700 text-sm text-slate-100 placeholder-slate-500 focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all resize-none"></textarea>
                        </div>

                        <div class="space-y-3 pt-4 border-t border-slate-800">
                            <button type="submit" name="status" value="approved" class="w-full py-4 px-6 bg-emerald-500 hover:bg-emerald-400 text-slate-950 text-xs font-black uppercase tracking-widest rounded-2xl transition-all text-center border-b-4 border-emerald-600 hover:border-emerald-500 hover:translate-y-[2px] active:border-b-0 active:translate-y-[4px]">
                                Setujui Pemesanan
                            </button>
                            <button type="submit" name="status" value="rejected" class="w-full py-4 px-6 bg-transparent hover:bg-rose-500/10 text-rose-400 hover:text-rose-300 text-xs font-black uppercase tracking-widest rounded-2xl transition-all text-center border-2 border-slate-800 hover:border-rose-500/30">
                                Tolak
                            </button>
                        </div>
                    </form>
                @else
                    <div class="text-center py-6 space-y-4">
                        <div class="w-16 h-16 mx-auto rounded-full flex items-center justify-center {{ $approval->status === 'approved' ? 'bg-emerald-500/20 text-emerald-400' : 'bg-rose-500/20 text-rose-400' }}">
                            @if($approval->status === 'approved')
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            @else
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-widest">Telah Direspon</p>
                            <h4 class="text-2xl font-black mt-1 {{ $approval->status === 'approved' ? 'text-emerald-400' : 'text-rose-400' }}">
                                {{ strtoupper($approval->status) }}
                            </h4>
                            <p class="text-[10px] text-slate-500 mt-2 font-mono">{{ $approval->approved_at?->format('d/m/Y H:i') ?? '-' }}</p>
                        </div>

                        @if($approval->notes)
                        <div class="mt-6 pt-6 border-t border-slate-800 text-left">
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Catatan:</p>
                            <p class="text-xs text-slate-300 italic">"{{ $approval->notes }}"</p>
                        </div>
                        @endif
                    </div>
                @endif

            </div>
        </div>

    </div>
</div>
@endsection