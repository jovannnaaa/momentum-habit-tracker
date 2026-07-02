<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Momentum · Build habits that stick</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
    <div class="mx-auto flex min-h-screen max-w-4xl flex-col items-center justify-center px-6 text-center">
        <span class="mb-4 text-5xl">🔥</span>
        <h1 class="text-4xl font-bold tracking-tight sm:text-5xl">Momentum</h1>
        <p class="mt-4 max-w-xl text-lg text-slate-600">
            Track daily habits, build streaks, and watch small consistent actions
            compound into lasting change.
        </p>
        <div class="mt-8 flex gap-4">
            <a href="{{ route('register') }}" class="rounded-lg bg-indigo-600 px-6 py-3 text-sm font-semibold text-white hover:bg-indigo-700">
                Get started free
            </a>
            <a href="{{ route('login') }}" class="rounded-lg border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Log in
            </a>
        </div>

        <div class="mt-16 grid grid-cols-1 gap-6 text-left sm:grid-cols-3">
            <div class="rounded-xl border border-slate-200 bg-white p-5">
                <div class="text-2xl">✅</div>
                <h3 class="mt-2 font-semibold">Daily check-ins</h3>
                <p class="mt-1 text-sm text-slate-500">One tap to mark a habit done for today.</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-5">
                <div class="text-2xl">📈</div>
                <h3 class="mt-2 font-semibold">Streak tracking</h3>
                <p class="mt-1 text-sm text-slate-500">See your current and longest streaks at a glance.</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-5">
                <div class="text-2xl">🗂️</div>
                <h3 class="mt-2 font-semibold">Categories</h3>
                <p class="mt-1 text-sm text-slate-500">Group habits by health, learning, mindfulness &amp; more.</p>
            </div>
        </div>
    </div>
</body>
</html>
