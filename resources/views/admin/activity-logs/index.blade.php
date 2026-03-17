@extends('layouts.app')

@section('content')
    <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Log Aktivitas</h1>
            <p class="text-sm text-slate-500 mt-1">Rekam jejak seluruh perubahan data dalam sistem</p>
        </div>

        <form action="{{ route('admin.activity-logs.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
            <div class="space-y-1.5">
                <!-- <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Rentang Tanggal</label> -->
                <input type="date" name="date" value="{{ request('date') }}" 
                    class="block px-4 py-2.5 text-xs rounded-2xl border border-slate-200 bg-white focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all">
            </div>
            
            <div class="space-y-1.5">
                <!-- <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Kategori Aksi</label> -->
                <select name="action" class="block px-4 py-2.5 text-xs rounded-2xl border border-slate-200 bg-white focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all">
                    <option value="">Semua Aktivitas</option>
                    <optgroup label="Booking">
                        <option value="booking.created"   {{ request('action') == 'booking.created'   ? 'selected' : '' }}>Pesanan Dibuat</option>
                        <option value="booking.cancelled" {{ request('action') == 'booking.cancelled' ? 'selected' : '' }}>Pesanan Dibatalkan</option>
                        <option value="booking.completed" {{ request('action') == 'booking.completed' ? 'selected' : '' }}>Pesanan Selesai</option>
                    </optgroup>
                    <optgroup label="Approval">
                        <option value="approval.approved_l1" {{ request('action') == 'approval.approved_l1' ? 'selected' : '' }}>Disetujui Level 1</option>
                        <option value="approval.rejected_l1" {{ request('action') == 'approval.rejected_l1' ? 'selected' : '' }}>Ditolak Level 1</option>
                        <option value="approval.approved_l2" {{ request('action') == 'approval.approved_l2' ? 'selected' : '' }}>Disetujui Level 2</option>
                        <option value="approval.rejected_l2" {{ request('action') == 'approval.rejected_l2' ? 'selected' : '' }}>Ditolak Level 2</option>
                    </optgroup>
                </select>
            </div>

            <div class="flex items-end gap-2 pb-0.5">
                <x-button type="submit" variant="primary" class="py-2.5 px-5 text-xs shadow-sm">
                    Terapkan
                </x-button>
                @if(request()->anyFilled(['date', 'action']))
                    <a href="{{ route('admin.activity-logs.index') }}" 
                       class="h-10 flex items-center px-4 text-xs text-slate-400 font-bold hover:text-rose-500 transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <x-table>
        <x-slot name="thead">
            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em]">Timestamp</th>
            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em]">Eksekutor</th>
            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em]">Aksi</th>
            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em]">Detail Perubahan</th>
            <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em]">Network ID</th>
        </x-slot>

        <x-slot name="tbody">
            @forelse ($logs as $log)
                <tr class="hover:bg-slate-50/40 transition-colors group border-b border-slate-50 last:border-0">
                    <td class="px-8 py-5 whitespace-nowrap">
                        <p class="text-xs font-bold text-slate-700">{{ $log->created_at->format('d M Y') }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5 font-medium">{{ $log->created_at->format('H:i') }} WIB</p>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <p class="text-xs font-bold text-slate-800 tracking-tight">{{ $log->user->name ?? 'System' }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5">{{ $log->user->role ?? '-' }}</p>
                    </td>
                    <td class="px-8 py-5">
                        @php
                            $badgeStyle = match(true) {
                                str_contains($log->action, 'created')   => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                str_contains($log->action, 'completed') => 'bg-blue-50 text-blue-600 border-blue-100',
                                str_contains($log->action, 'approved')  => 'bg-teal-50 text-teal-600 border-teal-100',
                                str_contains($log->action, 'cancelled') => 'bg-orange-50 text-orange-600 border-orange-100',
                                str_contains($log->action, 'rejected')  => 'bg-rose-50 text-rose-600 border-rose-100',
                                default                                  => 'bg-slate-50 text-slate-600 border-slate-100',
                            };
                        @endphp
                        <span class="inline-flex px-2.5 py-1 rounded-lg border text-[9px] font-black uppercase tracking-wider {{ $badgeStyle }}">
                            {{ str_replace('.', ' ', $log->action) }}
                        </span>
                    </td>
                    <td class="px-8 py-5">
                        <p class="text-xs text-slate-600 leading-relaxed italic font-medium">
                            "{{ $log->description }}"
                        </p>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <span class="text-[10px] font-mono text-slate-400 bg-slate-50 px-2.5 py-1 rounded-md border border-slate-100 font-bold">
                            {{ $log->ip_address ?? '127.0.0.1' }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-8 py-20 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mb-4 text-slate-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </div>
                            <p class="text-sm text-slate-400 font-medium italic">Tidak ada rekam aktivitas untuk periode ini.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-between items-center">
                <p class="text-xs text-slate-400 font-medium italic">
                    Audit Trail: <span class="font-bold text-gray-800 px-1">{{ $logs->total() }}</span> Aktivitas Tercatat
                </p>
                
                @if(method_exists($logs, 'links'))
                    <div class="scale-90 origin-right custom-pagination">
                        {{ $logs->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </x-slot>
    </x-table>
@endsection