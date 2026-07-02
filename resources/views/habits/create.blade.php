@extends('layouts.app')

@section('title', 'New habit')

@section('content')
    <div class="mx-auto max-w-lg">
        <h1 class="mb-6 text-2xl font-bold">Create a new habit</h1>

        <form method="POST" action="{{ route('habits.store') }}" class="space-y-5 rounded-xl border border-slate-200 bg-white p-6">
            @csrf
            @include('habits._form')

            <button type="submit" class="w-full rounded-lg bg-indigo-600 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
                Create habit
            </button>
        </form>
    </div>
@endsection
