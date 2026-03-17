@props(['title', 'value', 'icon', 'color'])

@php
    $colors = [
        'emerald' => 'bg-emerald-50 text-emerald-600',
        'blue' => 'bg-blue-50 text-blue-600',
        'amber' => 'bg-amber-50 text-amber-600',
        'rose' => 'bg-rose-50 text-rose-600',
    ];
@endphp

<div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-5 transition-transform hover:scale-[1.02]">
    <div class="w-12 h-12 rounded-2xl flex items-center justify-center {{ $colors[$color] ?? 'bg-slate-50 text-slate-600' }}">
        {{-- Kamu bisa pakai icon pack favoritmu di sini --}}
        <span class="font-bold text-xs uppercase">{{ substr($title, 0, 1) }}</span>
    </div>
    <div>
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $title }}</p>
        <p class="text-xl font-black text-slate-800">{{ $value }}</p>
    </div>
</div>