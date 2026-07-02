@extends('layouts.guest')

@section('title', 'Log in')

@section('content')
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
            <input id="password" type="password" name="password" required
                class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <label class="flex items-center gap-2 text-sm text-slate-600">
            <input type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
            Remember me
        </label>

        <button type="submit" class="w-full rounded-lg bg-indigo-600 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
            Log in
        </button>

        <p class="text-center text-sm text-slate-500">
            New here?
            <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:underline">Create an account</a>
        </p>

        <p class="rounded-lg bg-slate-50 p-3 text-center text-xs text-slate-500">
            Demo login: <strong>demo@momentum.test</strong> / <strong>password</strong>
        </p>
    </form>
@endsection
