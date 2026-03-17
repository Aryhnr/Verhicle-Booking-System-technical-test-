@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Log Pemesanan</h1>
            <p class="text-sm text-slate-500 mt-1">Manajemen operasional armada & driver</p>
        </div>
        
        <x-button variant="primary" :href="route('admin.bookings.create')">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Buat Pesanan
        </x-button>
    </div>

    <x-table>
        <x-slot name="thead">
            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kode & Pemohon</th>
            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kendaraan & Driver</th>
            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tujuan & Waktu</th>
            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider text-right">Aksi</th>
        </x-slot>

        <x-slot name="tbody">
            @forelse ($bookings as $booking)
                <tr class="hover:bg-slate-50/80 transition-colors border-b border-slate-50 last:border-0">
                    <td class="px-6 py-4">
                        <p class="text-[11px] font-bold text-emerald-600 tracking-widest uppercase mb-1">{{ $booking->booking_code }}</p>
                        <p class="text-sm font-bold text-slate-800">{{ $booking->requester_name }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm text-slate-700 font-bold tracking-tight">{{ $booking->vehicle->name }}</p>
                        <p class="text-[11px] text-slate-400 font-medium italic">Driver: <span class="text-slate-600 font-bold not-italic">{{ $booking->driver->name }}</span></p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm text-slate-600 truncate max-w-[150px] font-medium">{{ $booking->destination }}</p>
                        <p class="text-[10px] text-slate-400 uppercase font-bold tracking-tighter">{{ $booking->start_datetime->format('d M, H:i') }} WIB</p>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $statusClasses = [
                                'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                'approved' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                'rejected' => 'bg-rose-50 text-rose-600 border-rose-100',
                                'completed' => 'bg-blue-50 text-blue-600 border-blue-100'
                            ];
                        @endphp
                        <span class="inline-flex px-2.5 py-1 rounded-lg {{ $statusClasses[$booking->status] ?? 'bg-slate-50 text-slate-500 border-slate-100' }} text-[9px] font-black uppercase tracking-widest border">
                            {{ $booking->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <x-button variant="secondary" :href="route('admin.bookings.show', $booking)" class="py-1.5 px-3 text-[11px]">
                            Detail
                        </x-button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <p class="text-sm text-slate-400 italic font-medium">Belum ada riwayat pemesanan.</p>
                    </td>
                </tr>
            @endforelse
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-between items-center">
                <p class="text-xs text-slate-400 font-medium italic">
                    Total: <span class="font-bold text-gray-800 px-1">{{ $bookings->count() }}</span> Data Pemesanan
                </p>
                
                @if(method_exists($bookings, 'links'))
                    <div class="scale-90 origin-right custom-pagination">
                        {{ $bookings->links() }}
                    </div>
                @endif
            </div>
        </x-slot>
    </x-table>
@endsection