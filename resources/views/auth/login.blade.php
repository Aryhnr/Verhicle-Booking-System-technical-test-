<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | V-Logs Pro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full flex items-center justify-center p-6">
    <div class="max-w-md w-full">
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
            <div class="text-center mb-10">
                <h1 class="text-2xl font-bold text-slate-900">Selamat Datang</h1>
                <p class="text-slate-500 text-sm">Vehicle Booking System</p>
            </div>
            @if(session('error'))
                <div class="mb-4 p-3 bg-red-50 text-red-600 text-sm rounded-xl border border-red-100 italic">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email Address</label>
                    <input type="email" name="email" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-green-400 focus:border-transparent outline-none transition-all" placeholder="name@company.com">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-green-400 focus:border-transparent outline-none transition-all" placeholder="••••••••">
                </div>
                <button type="submit" class="w-full bg-slate-900 text-white font-bold py-4 rounded-xl hover:bg-slate-800 transition-all shadow-lg shadow-slate-200">
                    Sign In
                </button>
            </form>
        </div>
    </div>
</body>
</html>