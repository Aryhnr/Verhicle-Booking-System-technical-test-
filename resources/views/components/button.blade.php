@props([
    'variant' => 'primary',
    'type' => 'button',
    'href' => null
])

@php
    $baseStyles = "inline-flex items-center justify-center px-6 py-3 rounded-2xl font-bold text-[13px] tracking-wide transition-all duration-300 active:scale-[0.97] gap-2.5 disabled:opacity-40 disabled:pointer-events-none outline-none focus:ring-2 focus:ring-offset-2";
    
    $variants = [
        // Dark & Professional
        'primary' => 'bg-slate-900 text-white hover:bg-slate-800 focus:ring-slate-900 border border-transparent shadow-sm',
        
        // Soft Emerald (RS Delta Surya Theme)
        'success' => 'bg-emerald-500 text-white hover:bg-emerald-600 focus:ring-emerald-400 border border-transparent shadow-sm',
        
        // Clean White with subtle border
        'secondary' => 'bg-white text-slate-600 border border-slate-200 hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900 focus:ring-slate-200',
        
        // Soft Danger (Rose tone)
        'danger' => 'bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white border border-rose-100/50 focus:ring-rose-200',
        
        // Minimalist Ghost
        'ghost' => 'bg-transparent text-slate-400 hover:bg-slate-100/80 hover:text-slate-700 border border-transparent',
        
        // Emerald Accent (For special call-to-actions)
        'accent' => 'bg-emerald-50 text-emerald-700 border border-emerald-100 hover:bg-emerald-100 focus:ring-emerald-100'
    ];

    $classes = $baseStyles . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => $type, 'class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif