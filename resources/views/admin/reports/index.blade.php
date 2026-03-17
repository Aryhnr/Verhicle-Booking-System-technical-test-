@extends('layouts.app')

@section('content')
<div class="space-y-8">
    {{-- Header & Export --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight text-center md:text-left">Laporan Pemesanan</h1>
            <p class="text-sm text-slate-500 mt-1 text-center md:text-left">Analisis dan ekspor data logistik armada</p>
        </div>
        <div class="flex justify-center">
            <a href="{{ route('admin.reports.export', request()->query()) }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black uppercase tracking-widest rounded-2xl transition-all shadow-lg shadow-emerald-600/20 active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Ekspor Excel
            </a>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="bg-white p-5 rounded-[1.5rem] border border-slate-100 shadow-sm">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Total</p>
            <p class="text-xl font-black text-slate-800">{{ $summary['total'] }}</p>
        </div>
        <div class="bg-white p-5 rounded-[1.5rem] border border-slate-100 shadow-sm border-l-4 border-l-amber-400">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Pending</p>
            <p class="text-xl font-black text-amber-600">{{ $summary['pending'] }}</p>
        </div>
        <div class="bg-white p-5 rounded-[1.5rem] border border-slate-100 shadow-sm border-l-4 border-l-emerald-400">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Disetujui</p>
            <p class="text-xl font-black text-emerald-600">{{ $summary['approved'] }}</p>
        </div>
        <div class="bg-white p-5 rounded-[1.5rem] border border-slate-100 shadow-sm border-l-4 border-l-blue-400">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Selesai</p>
            <p class="text-xl font-black text-blue-600">{{ $summary['completed'] }}</p>
        </div>
        <div class="bg-white p-5 rounded-[1.5rem] border border-slate-100 shadow-sm border-l-4 border-l-rose-400 col-span-2 lg:col-span-1">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Ditolak</p>
            <p class="text-xl font-black text-rose-600">{{ $summary['rejected'] }}</p>
        </div>
    </div>

    {{-- Filter Form --}}
    <div class="bg-slate-900 rounded-[2rem] p-6 shadow-xl shadow-slate-900/10">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-col md:flex-row items-center gap-6">
            <div class="w-full md:w-auto space-y-1.5 flex-1">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] ml-1">Pilih Bulan</label>
                <select name="month" class="w-full block px-4 py-3 text-xs rounded-xl bg-slate-800 border border-slate-700 text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                    <option value="">Semua Bulan</option>
                    @foreach($months as $m)
                        <option value="{{ $m['value'] }}" {{ request('month', now()->month) == $m['value'] ? 'selected' : '' }}>
                            {{ $m['label'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="w-full md:w-auto space-y-1.5 flex-1">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] ml-1">Pilih Tahun</label>
                <select name="year" class="w-full block px-4 py-3 text-xs rounded-xl bg-slate-800 border border-slate-700 text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                    @foreach($years as $year)
                        <option value="{{ $year }}" {{ request('year', now()->year) == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="w-full md:w-auto pt-4 md:pt-5">
                <button type="submit" class="w-full md:w-auto px-8 py-3 bg-white text-slate-900 text-xs font-black uppercase tracking-widest rounded-xl hover:bg-emerald-400 transition-colors active:scale-95">
                    Filter Data
                </button>
            </div>
        </form>
    </div>

    {{-- Table Data --}}
    <x-table>
        <x-slot name="thead">
            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kode & Pemohon</th>
            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Unit Armada</th>
            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Rute Tujuan</th>
            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Jadwal</th>
            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Otorisasi</th>
            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Status</th>
        </x-slot>

        <x-slot name="tbody">
            @forelse($bookings as $booking)
                <tr class="hover:bg-slate-50/30 transition-colors group border-b border-slate-50 last:border-0">
                    <td class="px-8 py-5 whitespace-nowrap">
                        <p class="text-xs font-black text-slate-800 tracking-tighter">{{ $booking->booking_code }}</p>
                        <p class="text-[10px] text-slate-500 italic mt-0.5">{{ $booking->requester_name }}</p>
                    </td>
                    <td class="px-8 py-5">
                        <p class="text-xs font-bold text-emerald-700 uppercase tracking-tighter">{{ $booking->vehicle?->name }}</p>
                        <p class="text-[10px] font-mono text-slate-400">{{ $booking->vehicle?->plate_number }}</p>
                    </td>
                    <td class="px-8 py-5">
                        <p class="text-xs text-slate-700 font-medium">{{ $booking->destination }}</p>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <p class="text-[10px] font-bold text-slate-800">{{ $booking->start_datetime?->format('d/m/Y') }}</p>
                        <p class="text-[9px] text-slate-400 font-mono italic">s/d {{ $booking->end_datetime?->format('d/m/Y') }}</p>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex flex-col gap-1">
                            @foreach($booking->approvals as $app)
                                <div class="flex items-center gap-1.5">
                                    <div class="w-1.5 h-1.5 rounded-full {{ $app->status === 'approved' ? 'bg-emerald-400' : ($app->status === 'rejected' ? 'bg-rose-400' : 'bg-slate-200') }}"></div>
                                    <span class="text-[9px] text-slate-500 font-bold uppercase truncate max-w-[80px]">{{ $app->approver?->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-8 py-5 text-right">
                        <span class="inline-flex px-2.5 py-1 rounded-lg border text-[9px] font-black uppercase tracking-widest
                            {{ $booking->status === 'completed' ? 'bg-blue-50 text-blue-600 border-blue-100' : 
                            ($booking->status === 'rejected' ? 'bg-rose-50 text-rose-600 border-rose-100' : 
                            'bg-slate-100 text-slate-500 border-slate-200') }}">
                            {{ str_replace('_', ' ', $booking->status) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-8 py-20 text-center">
                        <p class="text-xs text-slate-400 italic">Data tidak ditemukan untuk periode ini.</p>
                    </td>
                </tr>
            @endforelse
        </x-slot>

        {{-- Footer dengan Pagination --}}
        <x-slot name="footer">
            <div class="flex justify-between items-center">
                <p class="text-xs text-slate-400 font-medium italic">
                    Menampilkan <span class="font-bold text-gray-800 px-1">{{ $bookings->count() }}</span> Riwayat Pemesanan
                </p>
                
                @if(method_exists($bookings, 'links'))
                    <div class="scale-90 origin-right custom-pagination">
                        {{ $bookings->links() }}
                    </div>
                @endif
            </div>
        </x-slot>
    </x-table>
</div>
@endsection