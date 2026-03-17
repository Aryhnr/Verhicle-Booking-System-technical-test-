@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Monitoring BBM</h1>
            <p class="text-sm text-slate-500 mt-1">Catatan konsumsi bahan bakar armada</p>
        </div>
        
        <x-button variant="primary" :href="route('admin.fuel-logs.create')">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Input Log BBM
        </x-button>
    </div>

    <x-table>
        <x-slot name="thead">
            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tanggal</th>
            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kendaraan</th>
            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Liter & Odometer</th>
            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Biaya</th>
            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider text-right">Aksi</th>
        </x-slot>

        <x-slot name="tbody">
            @forelse ($fuellogs as $log)
                <tr class="hover:bg-slate-50/80 transition-colors border-b border-slate-50 last:border-0">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <p class="text-sm font-bold text-slate-800">{{ $log->date->format('d M Y') }}</p>
                        <p class="text-[10px] text-slate-400 uppercase tracking-tighter">{{ $log->booking ? 'Ref: ' . $log->booking->booking_code : 'Umum' }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm text-slate-700 font-bold tracking-tight">{{ $log->vehicle->name }}</p>
                        <p class="text-[11px] text-emerald-600 font-mono font-bold">{{ $log->vehicle->plate_number }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm text-slate-600">{{ $log->liters }} <span class="text-[10px] font-bold uppercase">Ltr</span></p>
                        <p class="text-[11px] text-slate-400 italic tracking-tighter">{{ number_format($log->odometer_km) }} km</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm font-black text-slate-800">Rp {{ number_format($log->cost, 0, ',', '.') }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-end gap-2">
                            <x-button variant="secondary" :href="route('admin.fuel-logs.edit', $log)" class="py-1.5 px-3 text-[11px]">
                                Edit
                            </x-button>
                            <form action="{{ route('admin.fuel-logs.destroy', $log) }}" method="POST" onsubmit="return confirm('Hapus log ini?')">
                                @csrf @method('DELETE')
                                <x-button type="submit" variant="danger" class="py-1.5 px-3 text-[11px]">Hapus</x-button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-400 italic text-sm">
                        Belum ada catatan konsumsi BBM.
                    </td>
                </tr>
            @endforelse
        </x-slot>

        {{-- Slot Footer untuk Pagination & Info --}}
        <x-slot name="footer">
            <div class="flex justify-between items-center">
                <p class="text-xs text-slate-400 font-medium italic">
                    Menampilkan <span class="font-bold text-gray-800 px-1">{{ $fuellogs->count() }}</span> Catatan BBM
                </p>
                
                @if(method_exists($fuellogs, 'links'))
                    <div class="scale-90 origin-right custom-pagination">
                        {{ $fuellogs->links() }}
                    </div>
                @endif
            </div>
        </x-slot>
    </x-table>
@endsection