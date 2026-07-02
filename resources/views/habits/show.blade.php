@extends('layouts.app')

@section('title', $habit->name)

@php
    $streak = $habit->currentStreak();
    $longest = $habit->longestStreak();
    $rate = $habit->completionRate(30);
    $checkedInToday = $habit->isCheckedInToday();

    // Build the last 30 days for a simple activity grid (oldest first).
    $days = collect(range(29, 0))->map(fn ($i) => now()->subDays($i)->toDateString());
    $checkedDates = $habit->checkIns->pluck('date')->map(fn ($d) => $d->toDateString())->flip();
@endphp

@section('content')
    <div class="mb-6 flex flex-wrap items-start justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-2xl font-bold">{{ $habit->name }}</h1>
                @if ($habit->is_archived)
                    <span class="rounded-full bg-slate-200 px-2 py-0.5 text-xs font-medium text-slate-600">Archived</span>
                @endif
            </div>
            @if ($habit->category)
                <span class="mt-1 inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs" style="background-color: {{ $habit->category->color }}20; color: {{ $habit->category->color }}">
                    {{ $habit->category->name }}
                </span>
            @endif
            @if ($habit->description)
                <p class="mt-2 max-w-lg text-slate-600">{{ $habit->description }}</p>
            @endif
        </div>

        <div class="flex gap-2">
            <a href="{{ route('habits.edit', $habit) }}" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium hover:bg-slate-50">Edit</a>
            <form method="POST" action="{{ route('habits.archive', $habit) }}">
                @csrf
                <button class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium hover:bg-slate-50">
                    {{ $habit->is_archived ? 'Restore' : 'Archive' }}
                </button>
            </form>
        </div>
    </div>

    <div class="mb-6 grid grid-cols-3 gap-4">
        <div class="rounded-xl border border-slate-200 bg-white p-4 text-center">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Current streak</p>
            <p class="mt-1 text-2xl font-bold">🔥 {{ $streak }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 text-center">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Longest streak</p>
            <p class="mt-1 text-2xl font-bold">🏆 {{ $longest }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 text-center">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-400">30-day rate</p>
            <p class="mt-1 text-2xl font-bold">{{ $rate }}%</p>
        </div>
    </div>

    <div class="mb-6 rounded-xl border border-slate-200 bg-white p-4">
        <div class="mb-3 flex items-center justify-between">
            <h2 class="font-semibold">Last 30 days</h2>
            <form method="POST" action="{{ route('habits.check-in', $habit) }}">
                @csrf
                <button type="submit"
                    class="rounded-lg px-4 py-2 text-sm font-semibold {{ $checkedInToday ? 'bg-emerald-500 text-white hover:bg-emerald-600' : 'bg-indigo-600 text-white hover:bg-indigo-700' }}">
                    {{ $checkedInToday ? '✓ Checked in today' : 'Check in for today' }}
                </button>
            </form>
        </div>
        <div class="grid grid-cols-10 gap-1.5 sm:grid-cols-15">
            @foreach ($days as $day)
                <div title="{{ $day }}"
                    class="aspect-square rounded {{ $checkedDates->has($day) ? 'bg-emerald-500' : 'bg-slate-100' }}"></div>
            @endforeach
        </div>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-4">
        <h2 class="mb-3 font-semibold">Recent check-ins</h2>
        @if ($habit->checkIns->isEmpty())
            <p class="text-sm text-slate-500">No check-ins yet.</p>
        @else
            <ul class="divide-y divide-slate-100">
                @foreach ($habit->checkIns->take(10) as $checkIn)
                    <li class="flex items-center justify-between py-2 text-sm">
                        <span>{{ $checkIn->date->format('D, M j Y') }}</span>
                        @if ($checkIn->note)
                            <span class="text-slate-400">{{ $checkIn->note }}</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
