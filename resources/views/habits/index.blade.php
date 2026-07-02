@extends('layouts.app')

@section('title', 'Habits')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold">Your habits</h1>
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
