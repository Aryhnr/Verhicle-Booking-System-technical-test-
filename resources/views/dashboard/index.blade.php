@extends('layouts.app')

@section('content')
<div class="space-y-8">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight transition-all">Halo, {{ auth()->user()->name }}!</h1>
            <p class="text-sm text-slate-500 mt-1">Berikut adalah ringkasan aktivitas sistem hari ini.</p>
        </div>
        <div class="hidden md:block">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] bg-slate-100 px-4 py-2 rounded-full">
                {{ now()->format('d F Y') }}
            </span>
        </div>
    </div>

    @if(auth()->user()->role === 'admin')
        {{-- Statistik Admin --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-5 transition-transform hover:scale-[1.02]">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center bg-emerald-50 text-emerald-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Kendaraan</p>
                    <p class="text-xl font-black text-slate-800">{{ $data['total_vehicles'] }}</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-5 transition-transform hover:scale-[1.02]">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center bg-blue-50 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Pengemudi</p>
                    <p class="text-xl font-black text-slate-800">{{ $data['total_drivers'] }}</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-5 transition-transform hover:scale-[1.02]">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center bg-amber-50 text-amber-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Booking (Bulan Ini)</p>
                    <p class="text-xl font-black text-slate-800">{{ $data['total_bookings'] }}</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-5 transition-transform hover:scale-[1.02]">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center bg-rose-50 text-rose-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Menunggu Persetujuan</p>
                    <p class="text-xl font-black text-rose-600">{{ $data['pending_count'] }}</p>
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Grafik Booking (Fixed Height) --}}
            <div class="lg:col-span-2 bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm shadow-slate-200/50 flex flex-col min-h-[450px]">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-8">Grafik Pemesanan {{ date('Y') }}</h3>
                
                {{-- Container Relatif & Fixed Height --}}
                <div class="relative flex-1 w-full" style="min-height: 300px;">
                    <canvas id="bookingChart"></canvas>
                </div>
            </div>

            {{-- Booking Terbaru --}}
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm shadow-slate-200/50">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Paling Baru</h3>
                    <a href="{{ route('admin.bookings.index') }}" class="text-[10px] font-bold text-emerald-500 hover:underline tracking-tighter">LIHAT SEMUA</a>
                </div>
                
                <div class="space-y-6">
                    @forelse($data['recent_bookings'] as $booking)
                        <div class="flex items-center gap-4 group cursor-default">
                            <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 font-bold text-[10px] group-hover:bg-emerald-50 group-hover:text-emerald-500 transition-colors">
                                {{ $loop->iteration }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-slate-800 truncate uppercase tracking-tighter">{{ $booking->booking_code }}</p>
                                <p class="text-[10px] text-slate-400 truncate italic">{{ $booking->destination }}</p>
                            </div>
                            <span class="text-[9px] font-black uppercase px-2 py-1 {{ $booking->status === 'pending' ? 'bg-amber-50 text-amber-500' : 'bg-slate-50 text-slate-400' }} rounded-md border border-black/5">
                                {{ $booking->status }}
                            </span>
                        </div>
                    @empty
                        <div class="py-10 text-center">
                            <p class="text-xs text-slate-400 italic">Belum ada data pemesanan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    @else
        {{-- Tampilan Approver --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="bg-emerald-900 rounded-[2.5rem] p-8 text-white flex items-center justify-between shadow-xl shadow-emerald-900/20">
                <div>
                    <p class="text-emerald-300 text-[10px] font-bold uppercase tracking-[0.2em]">Tugas Menunggu</p>
                    <h2 class="text-5xl font-black mt-2">{{ $data['pending_count'] }}</h2>
                </div>
                <div class="w-16 h-16 bg-emerald-800 rounded-2xl flex items-center justify-center border border-emerald-700">
                    <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
            </div>

            <div class="lg:col-span-2 bg-white rounded-[2.5rem] border border-slate-100 p-8 shadow-sm">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-8">Daftar Persetujuan</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left min-w-[500px]">
                        <thead>
                            <tr class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.15em] border-b border-slate-50">
                                <th class="pb-4 px-2">Kode Booking</th>
                                <th class="pb-4 px-2">Tujuan Tugas</th>
                                <th class="pb-4 px-2">Nomor Plat</th>
                                <th class="pb-4 px-2 text-right">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($data['recent_approvals'] as $approval)
                                <tr class="group hover:bg-slate-50/50 transition-colors">
                                    <td class="py-5 px-2 text-xs font-bold text-slate-700 tracking-tighter">{{ $approval->booking->booking_code }}</td>
                                    <td class="py-5 px-2 text-xs text-slate-500">{{ $approval->booking->destination }}</td>
                                    <td class="py-5 px-2">
                                        <span class="text-[10px] font-mono font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded border border-emerald-100 italic">
                                            {{ $approval->booking->vehicle->plate_number }}
                                        </span>
                                    </td>
                                    <td class="py-5 px-2 text-right">
                                        <a href="{{ route('approvals.show', $approval->id) }}" class="inline-flex items-center gap-1 text-[10px] font-black text-emerald-600 hover:text-emerald-700 uppercase tracking-widest transition-all">
                                            Periksa <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-10 text-center text-xs text-slate-400 italic">Tidak ada antrian persetujuan saat ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

{{-- Chart Script --}}
@if(auth()->user()->role === 'admin')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('bookingChart').getContext('2d');
        
        // Gradient effect biar makin industrial/modern
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(16, 185, 129, 0.2)');
        gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($data['chart_data']['labels']) !!},
                datasets: [{
                    label: 'Total Pesanan',
                    data: {!! json_encode($data['chart_data']['totals']) !!},
                    borderColor: '#10b981',
                    backgroundColor: gradient,
                    borderWidth: 4,
                    fill: true,
                    tension: 0.45,
                    pointRadius: 6,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#10b981',
                    pointBorderWidth: 3,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: '#10b981',
                    pointHoverBorderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Penting: agar mengikuti tinggi container div
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleFont: { size: 10, weight: 'bold' },
                        bodyFont: { size: 12 },
                        padding: 12,
                        cornerRadius: 12,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { 
                            display: true,
                            color: '#f8fafc',
                            drawBorder: false
                        },
                        ticks: { 
                            stepSize: 1,
                            font: { size: 10, weight: 'bold' },
                            color: '#94a3b8',
                            padding: 10
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { size: 10, weight: 'bold' },
                            color: '#94a3b8',
                            padding: 10
                        }
                    }
                }
            }
        });
    });
</script>
@endif
@endsection