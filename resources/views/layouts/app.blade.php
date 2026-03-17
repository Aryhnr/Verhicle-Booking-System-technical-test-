<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'V-Logs Pro') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700" rel="stylesheet" />

        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.min.js"></script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* 1. Menghilangkan flicker AlpineJS */
            [x-cloak] { display: none !important; }

            /* 2. Set Font Global */
            body { font-family: 'Plus Jakarta Sans', sans-serif; }

            /* 3. Custom Scrollbar Styling */
            .custom-scrollbar::-webkit-scrollbar { width: 5px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
            .custom-scrollbar::-webkit-scrollbar-thumb { 
                background: #cbd5e1; 
                border-radius: 10px; 
            }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        </style>
        @stack('styles')
    </head>
    <body class="antialiased bg-slate-50 text-slate-900 h-full overflow-hidden">

        <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
            
            <x-nav.sidebar />

            <div class="flex-1 flex flex-col min-w-0 h-full relative">
                
                <x-nav.navbar />

                <main class="flex-1 overflow-y-auto overflow-x-hidden custom-scrollbar bg-slate-50/50">
                    <div class="py-8 px-4 sm:px-8 lg:px-10 max-w-[1600px] mx-auto min-h-[calc(100vh-140px)]">
                        
                        @if (session('success') || session('error'))
                            <div x-data="{ show: true }" 
                                 x-show="show" 
                                 x-init="setTimeout(() => show = false, 5000)" 
                                 x-cloak 
                                 class="mb-6">
                                
                                @if (session('success'))
                                    <div class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl text-sm flex justify-between items-center shadow-sm">
                                        <div class="flex items-center gap-3">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                            <span class="font-medium">{{ session('success') }}</span>
                                        </div>
                                        <button @click="show = false" class="hover:bg-emerald-100 p-1 rounded-lg transition-colors">&times;</button>
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="p-4 bg-rose-50 border border-rose-100 text-rose-700 rounded-2xl text-sm flex justify-between items-center shadow-sm">
                                        <div class="flex items-center gap-3">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                                            <span class="font-medium">{{ session('error') }}</span>
                                        </div>
                                        <button @click="show = false" class="hover:bg-rose-100 p-1 rounded-lg transition-colors">&times;</button>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <div class="transition-all duration-500">
                            @yield('content')
                            {{ $slot ?? '' }} 
                        </div>
                    </div>

                    <footer class="py-6 px-4 sm:px-12 border-t border-slate-200/60 bg-white/50 backdrop-blur-md">
                        <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">
                            <p>© 2026 Vehicle Booking System</p>
                        </div>
                    </footer>
                </main>
            </div>
        </div>

        @stack('scripts')
    </body>
</html>