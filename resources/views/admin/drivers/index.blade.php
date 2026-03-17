@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Daftar Driver</h1>
            <p class="text-sm text-slate-500 mt-1">Personel pengemudi resmi RS Delta Surya</p>
        </div>
        
        <x-button variant="primary" :href="route('admin.drivers.create')">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Driver
        </x-button>
    </div>

    <x-table>
        <x-slot name="thead">
            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama & Kontak</th>
            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Lisensi</th>
            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider text-right">Aksi</th>
        </x-slot>

        <x-slot name="tbody">
            @forelse ($drivers as $driver)
                <tr class="hover:bg-slate-50/80 transition-colors border-b border-slate-50 last:border-0">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $driver->name }}</p>
                                <p class="text-[11px] text-slate-400 font-medium tracking-wide italic">{{ $driver->phone }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm text-slate-600 font-medium">{{ $driver->license_type }}</p>
                        <p class="text-[11px] text-slate-400 tracking-wider">{{ $driver->license_number }}</p>
                    </td>
                    <td class="px-6 py-4">
                        @if($driver->status === 'available')
                            <span class="inline-flex px-2 py-1 rounded-lg bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase tracking-wider border border-emerald-100">Tersedia</span>
                        @elseif($driver->status === 'on_duty')
                            <span class="inline-flex px-2 py-1 rounded-lg bg-blue-50 text-blue-600 text-[10px] font-bold uppercase tracking-wider border border-blue-100">Bertugas</span>
                        @else
                            <span class="inline-flex px-2 py-1 rounded-lg bg-rose-50 text-rose-600 text-[10px] font-bold uppercase tracking-wider border border-rose-100">Off / Izin</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <x-button variant="secondary" :href="route('admin.drivers.edit', $driver)" class="py-1.5 px-3 text-[11px]">
                                Edit
                            </x-button>
                            <form action="{{ route('admin.drivers.destroy', $driver) }}" method="POST" onsubmit="return confirm('Hapus data driver ini?')">
                                @csrf @method('DELETE')
                                <x-button type="submit" variant="danger" class="py-1.5 px-3 text-[11px]">Hapus</x-button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-slate-400 italic text-sm">
                        Belum ada data driver terdaftar.
                    </td>
                </tr>
            @endforelse
        </x-slot>

        {{-- Slot Footer untuk Pagination --}}
        <x-slot name="footer">
            <div class="flex justify-between items-center">
                <p class="text-xs text-slate-400 font-medium italic">
                    Menampilkan <span class="font-bold text-gray-800 px-1">{{ $drivers->count() }}</span> Personel Pengemudi
                </p>
                
                @if(method_exists($drivers, 'links'))
                    <div class="scale-90 origin-right custom-pagination">
                        {{ $drivers->links() }}
                    </div>
                @endif
            </div>
        </x-slot>
    </x-table>
@endsection