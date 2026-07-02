<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Momentum') · Momentum</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex min-h-screen items-center justify-center bg-gradient-to-br from-brand-50 to-slate-100 bg-slate-50 px-4">
    <div class="w-full max-w-sm">
        <div class="mb-8 text-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600">🔥 Momentum</a>
            <p class="mt-1 text-sm text-slate-500">Small habits, tracked daily, compound into big change.</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            @if ($errors->any())
                <div class="mb-4 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                    <ul class="list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </div>
    </div>
</body>
</html>
