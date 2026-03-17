@extends('layouts.app')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Antrian Persetujuan</h1>
        <p class="text-sm text-slate-500 mt-1">Daftar pemesanan kendaraan yang membutuhkan otorisasi</p>
    </div>
</div>

<div class="bg-white rounded-[2.5rem] border border-slate-100 overflow-hidden shadow-sm shadow-slate-200/50">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[900px]">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em]">Tanggal & Kode</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em]">Tujuan</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em]">Aset</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em]">Tingkat</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em]">Status</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em] text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse ($approvals as $approval)
                    <tr class="hover:bg-slate-50/40 transition-colors group">
                        <td class="px-8 py-5 whitespace-nowrap">
                            <p class="text-xs font-bold text-slate-800">{{ $approval->created_at->format('d M Y') }}</p>
                            <p class="text-[10px] font-mono text-slate-400 mt-0.5">{{ $approval->booking->booking_code }}</p>
                        </td>
                        <td class="px-8 py-5">
                            <p class="text-xs font-bold text-slate-700 truncate max-w-[200px]">{{ $approval->booking->destination }}</p>
                        </td>
                        <td class="px-8 py-5">
                            <p class="text-[11px] font-bold text-emerald-600">{{ $approval->booking->vehicle->name }}</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">{{ $approval->booking->driver->name ?? 'Tanpa Driver' }}</p>
                        </td>
                        <td class="px-8 py-5">
                            <span class="inline-flex px-2.5 py-1 rounded-md border border-slate-200 bg-white text-[9px] font-black text-slate-500 uppercase tracking-widest">
                                Level {{ $approval->level }}
                            </span>
                        </td>
                        <td class="px-8 py-5">
                            @php
                                $statusStyle = match($approval->status) {
                                    'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                    'approved' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'rejected' => 'bg-rose-50 text-rose-600 border-rose-100',
                                    default => 'bg-slate-50 text-slate-500 border-slate-100'
                                };
                            @endphp
                            <span class="inline-flex px-2.5 py-1 rounded-lg border text-[9px] font-black uppercase tracking-wider {{ $statusStyle }}">
                                {{ $approval->status }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <a href="{{ route('approvals.show', $approval->id) }}" class="inline-flex items-center justify-center px-4 py-2 bg-slate-900 hover:bg-emerald-600 text-white text-[10px] font-bold uppercase tracking-widest rounded-xl transition-all">
                                Review
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mb-4 text-slate-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <p class="text-sm text-slate-400 font-medium italic">Tidak ada antrian persetujuan saat ini.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8">
    {{ $approvals->links() }}
</div>
@endsection