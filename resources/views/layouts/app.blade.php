<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Momentum') · Momentum</title>
    <link rel="icon" href="data:,">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eef2ff', 100: '#e0e7ff', 500: '#6366f1',
                            600: '#4f46e5', 700: '#4338ca',
                        },
                    },
                },
            },
        }
    </script>
    <style>[x-cloak]{display:none}</style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">

    @auth
    <nav class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-4 py-3">
            <div class="flex items-center gap-6">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-lg font-bold text-brand-600">
                    <span>🔥</span> Momentum
                </a>
                <a href="{{ route('dashboard') }}" class="text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-brand-600' : 'text-slate-600 hover:text-slate-900' }}">Dashboard</a>
                <a href="{{ route('habits.index') }}" class="text-sm font-medium {{ request()->routeIs('habits.*') ? 'text-brand-600' : 'text-slate-600 hover:text-slate-900' }}">Habits</a>
                <a href="{{ route('categories.index') }}" class="text-sm font-medium {{ request()->routeIs('categories.*') ? 'text-brand-600' : 'text-slate-600 hover:text-slate-900' }}">Categories</a>
            </div>
            <div class="flex items-center gap-4">
                <span class="hidden text-sm text-slate-500 sm:inline">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-sm font-medium text-slate-600 hover:text-slate-900">Log out</button>
                </form>
            </div>
        </div>
    </nav>
    @endauth

    <main class="mx-auto max-w-5xl px-4 py-8">
        @if (session('status'))
            <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                <p class="font-medium">Please fix the following:</p>
                <ul class="mt-1 list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="mx-auto max-w-5xl px-4 pb-8 pt-4 text-center text-xs text-slate-400">
        Built with Laravel · Momentum &copy; {{ date('Y') }}
    </footer>
</body>
</html>
