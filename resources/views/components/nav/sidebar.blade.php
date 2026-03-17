@php
    $user = auth()->user();
@endphp

{{-- Overlay (mobile) --}}
<div x-show="sidebarOpen" 
     x-cloak
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm z-40 md:hidden" 
     @click="sidebarOpen = false"></div>

{{-- Sidebar --}}
<aside x-cloak
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       class="fixed inset-y-0 left-0 z-50 w-72 bg-gray-900 text-white flex flex-col h-screen transition-transform duration-300 ease-in-out md:relative md:translate-x-0 border-r border-gray-800">
    
    {{-- Logo --}}
    <div class="h-16 flex items-center justify-between px-6 border-b border-gray-800 shrink-0">
        <div class="items-center gap-3">
            <span class="text-lg font-bold tracking-tight uppercase">
                Vehicle Booking
            </span>
            <span class="text-sm text-green-500">System</span>
        </div>

        <button @click="sidebarOpen = false" 
                class="md:hidden text-gray-400 hover:text-white transition-colors p-1 rounded-md hover:bg-gray-800">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto custom-scrollbar overflow-x-hidden">

        {{-- Main --}}
        <div class="px-4 pb-2 text-[10px] font-bold tracking-[0.2em] text-gray-500 uppercase">
            Menu Utama
        </div>

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}" 
        class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-bold transition-all group {{ request()->routeIs('dashboard') ? 'bg-emerald-600 text-white shadow-emerald-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-emerald-600' }}">
            <span class="w-5 h-5 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            </span>
            Beranda
        </a>

        @if($user->role === 'approver')
            <a href="{{ route('approvals.index') }}" 
            class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-bold transition-all group {{ request()->routeIs('approvals.*') ? 'bg-emerald-600 text-white shadow-emerald-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-emerald-600' }}">
                <span class="w-5 h-5 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                </span>
                Menunggu Persetujuan
            </a>
        @endif

        {{-- Admin Only --}}
        @if($user->role === 'admin')

            <div class="px-4 pt-6 pb-2 text-[10px] font-bold tracking-[0.2em] text-gray-500 uppercase">
                Pemesanan
            </div>

            <a href="{{ route('admin.bookings.index') }}" 
            class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-bold transition-all group {{ request()->routeIs('admin.bookings.index') ? 'bg-emerald-600 text-white shadow-emerald-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-emerald-600' }}">
                <span class="w-5 h-5 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </span>
                Kelola Pemesanan
            </a>

            <a href="{{ route('admin.bookings.create') }}" 
            class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-bold transition-all group {{ request()->routeIs('admin.bookings.create') ? 'bg-emerald-600 text-white shadow-emerald-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-emerald-600' }}">
                <span class="w-5 h-5 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </span>
                Buat Pemesanan
            </a>

            <div class="px-4 pt-6 pb-2 text-[10px] font-bold tracking-[0.2em] text-gray-500 uppercase">
                Sumber Daya
            </div>

            <a href="{{ route('admin.vehicles.index') }}" 
            class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-bold transition-all group {{ request()->routeIs('admin.vehicles.*') ? 'bg-emerald-600 text-white shadow-emerald-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-emerald-600' }}">
                <span class="w-5 h-5 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                </span>
                Kendaraan
            </a>

            <a href="{{ route('admin.drivers.index') }}" 
            class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-bold transition-all group {{ request()->routeIs('admin.drivers.*') ? 'bg-emerald-600 text-white shadow-emerald-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-emerald-600' }}">
                <span class="w-5 h-5 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </span>
                Pengemudi
            </a>

            <a href="{{ route('admin.fuel-logs.index') }}" 
            class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-bold transition-all group {{ request()->routeIs('admin.fuel-logs.*') ? 'bg-emerald-600 text-white shadow-emerald-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-emerald-600' }}">
                <span class="w-5 h-5 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                </span>
                Konsumsi BBM
            </a>

            <div class="px-4 pt-6 pb-2 text-[10px] font-bold tracking-[0.2em] text-gray-500 uppercase">
                Sistem
            </div>

            <a href="{{ route('admin.reports.index') }}" 
            class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-bold transition-all group {{ request()->routeIs('admin.reports.*') ? 'bg-emerald-600 text-white shadow-emerald-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-emerald-600' }}">
                <span class="w-5 h-5 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </span>
                Laporan & Analitik
            </a>

            <a href="{{ route('admin.activity-logs.index') }}" 
            class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-bold transition-all group {{ request()->routeIs('admin.activity-logs.*') ? 'bg-emerald-600 text-white shadow-emerald-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-emerald-600' }}">
                <span class="w-5 h-5 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </span>
                Riwayat Aktivitas
            </a>

        @endif

    </nav>

    {{-- User + Logout --}}
    <div class="p-4 border-t border-gray-800 bg-gray-900/50">

        <form method="POST" action="{{ route('logout') }}" id="logout-form">
            @csrf
        </form>

        <button type="submit" form="logout-form"
            class="group flex items-center gap-3 w-full text-left p-2.5 rounded-xl hover:bg-gray-800 transition-all border border-transparent hover:border-gray-700">

            {{-- Info --}}
            <div class="overflow-hidden">
                <p class="text-xs font-semibold text-white truncate">
                    {{ $user->name }}
                </p>
                <p class="text-[10px] text-gray-500 font-medium truncate uppercase tracking-wider">
                    {{ $user->role === 'admin' 
                        ? 'Admin Sistem' 
                        : 'Approver Level ' . ($user->level ?? '-') 
                    }}
                </p>
            </div>

            {{-- Icon --}}
            <div class="ml-auto transition-opacity">
                <svg class="w-4 h-4 text-gray-500 group-hover:text-rose-400 transition-colors"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </div>

        </button>
    </div>

</aside>