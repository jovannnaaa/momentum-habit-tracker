@extends('layouts.app')

@section('title', 'Edit habit')

@section('content')
    <div class="mx-auto max-w-lg">
        <h1 class="mb-6 text-2xl font-bold">Edit habit</h1>

        <form method="POST" action="{{ route('habits.update', $habit) }}" class="space-y-5 rounded-xl border border-slate-200 bg-white p-6">
            @csrf
            @method('PUT')
            @include('habits._form')

            <button type="submit" class="w-full rounded-lg bg-indigo-600 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
                Save changes
            </button>
        </form>

        <form method="POST" action="{{ route('habits.destroy', $habit) }}" class="mt-4" onsubmit="return confirm('Delete this habit permanently? This also removes all its check-ins.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full rounded-lg border border-rose-200 py-2.5 text-sm font-semibold text-rose-600 hover:bg-rose-50">
                Delete habit
            </button>
        </form>
    </div>
@endsection
