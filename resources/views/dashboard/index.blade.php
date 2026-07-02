@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold">Welcome back, {{ auth()->user()->name }} 👋</h1>
        <p class="mt-1 text-slate-500">Here's how your habits are trending.</p>
    </div>

    <div class="mb-8 grid grid-cols-2 gap-4 sm:grid-cols-4">
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Active habits</p>
            <p class="mt-1 text-2xl font-bold">{{ $totalHabits }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Checked in today</p>
            <p class="mt-1 text-2xl font-bold">{{ $checkedInToday }} / {{ $totalHabits }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Best active streak</p>
            <p class="mt-1 text-2xl font-bold">🔥 {{ $longestActiveStreak }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-400">30-day completion</p>
            <p class="mt-1 text-2xl font-bold">{{ $avgCompletion }}%</p>
        </div>
    </div>

    <div class="mb-4 flex items-center justify-between">
        <h2 class="text-lg font-semibold">Today's habits</h2>
        <a href="{{ route('habits.create') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
            + New habit
        </a>
    </div>

    @if ($habits->isEmpty())
        <div class="rounded-xl border border-dashed border-slate-300 bg-white p-10 text-center">
            <p class="text-slate-500">You don't have any habits yet.</p>
            <a href="{{ route('habits.create') }}" class="mt-3 inline-block font-medium text-indigo-600 hover:underline">Create your first habit &rarr;</a>
        </div>
    @else
        <div class="space-y-3">
            @foreach ($habits as $habit)
                @include('habits._card', ['habit' => $habit])
            @endforeach
        </div>
    @endif
@endsection
