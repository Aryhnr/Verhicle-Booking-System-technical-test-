@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Daftar Kendaraan</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola armada operasional RS Delta Surya</p>
        </div>
        
        <x-button variant="primary" :href="route('admin.vehicles.create')">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Kendaraan
        </x-button>
    </div>

    <x-table>
        <x-slot name="thead">
            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kendaraan</th>
            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tipe / Kapasitas</th>
            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider text-right">Aksi</th>
        </x-slot>

        <x-slot name="tbody">
            {{-- Pastikan variabel $vehicles dikirim dari Controller --}}
            @forelse ($vehicles as $vehicle)
                <tr class="hover:bg-slate-50/80 transition-colors border-b border-slate-50 last:border-0">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            {{-- Inisial Nama Kendaraan --}}
                            <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center text-slate-500 font-bold">
                                {{ substr($vehicle->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $vehicle->name }}</p>
                                <p class="text-[11px] text-slate-400 font-medium tracking-wide uppercase">{{ $vehicle->plate_number }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm text-slate-600">{{ $vehicle->type }}</p>
                        <p class="text-[11px] text-slate-400 italic">Kapasitas: {{ $vehicle->capacity }} orang</p>
                    </td>
                    <td class="px-6 py-4">
                        @if($vehicle->is_active)
                            <span class="inline-flex px-2 py-1 rounded-lg bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase tracking-wider border border-emerald-100">
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex px-2 py-1 rounded-lg bg-rose-50 text-rose-600 text-[10px] font-bold uppercase tracking-wider border border-rose-100">
                                Non-Aktif
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <x-button variant="secondary" :href="route('admin.vehicles.edit', $vehicle->id)" class="py-1.5 px-3 text-[11px]">
                                Edit
                            </x-button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4 text-slate-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                            <p class="text-slate-500 font-medium">Belum ada data kendaraan.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-between items-center">
                <p class="text-xs text-slate-400 font-medium italic">
                    Menampilkan <span class="font-bold text-gray-800 px-1">{{ $vehicles->count() }}</span> data kendaraan
                </p>
                {{-- Link Pagination (jika menggunakan ->paginate()) --}}
                @if(method_exists($vehicles, 'links'))
                    <div class="scale-75 origin-right">
                        {{ $vehicles->links() }}
                    </div>
                @endif
            </div>
        </x-slot>
    </x-table>
@endsection