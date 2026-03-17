<header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-6 shadow-sm z-10">
    <div class="flex items-center gap-4">
        {{-- Burger Menu Mobile --}}
        <button @click="sidebarOpen = true" class="md:hidden text-slate-500 hover:text-slate-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
    </div>

    <div class="flex items-center gap-4">
        {{-- Profil User --}}
        <div class="flex items-center gap-3 pl-4 border-l border-slate-100">
            <div class="flex flex-col text-right hidden sm:block">
                <span class="text-xs font-black text-slate-800 uppercase tracking-tighter">{{ auth()->user()->name }}</span>
                <!-- <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ auth()->user()->role }}</span> -->
            </div>
            <div class="w-9 h-9 rounded-xl bg-slate-900 text-emerald-400 flex items-center justify-center font-black text-xs shadow-lg border border-slate-800">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
        </div>
    </div>
</header>