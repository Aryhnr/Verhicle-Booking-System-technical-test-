<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login · {{ config('app.name', 'Hospital Billing System') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>

<body class="antialiased bg-slate-100 text-slate-900">
    <main class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md">

            {{-- Auth content --}}
            @yield('content')

        </div>
    </main>

    @stack('scripts')
</body>
</html>
