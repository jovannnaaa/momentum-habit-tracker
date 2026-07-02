@extends('layouts.app')

@section('title', 'Categories')

@section('content')
    <h1 class="mb-6 text-2xl font-bold">Categories</h1>

    <div class="mb-8 grid gap-6 sm:grid-cols-2">
        <div class="space-y-3">
            @forelse ($categories as $category)
                <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-white p-4">
                    <div class="flex items-center gap-3">
                        <span class="h-3 w-3 rounded-full" style="background-color: {{ $category->color }}"></span>
                        <div>
                            <p class="font-medium">{{ $category->name }}</p>
                            <p class="text-xs text-slate-400">{{ $category->habits_count }} habit(s)</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('Delete this category? Habits will be uncategorized.');">
                        @csrf
                        @method('DELETE')
                        <button class="text-sm text-rose-500 hover:underline">Delete</button>
                    </form>
                </div>
            @empty
                <p class="text-sm text-slate-500">No categories yet &mdash; create one to start organizing your habits.</p>
            @endforelse
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6">
            <h2 class="mb-4 font-semibold">New category</h2>
            <form method="POST" action="{{ route('categories.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700">Name</label>
                    <input id="name" name="name" type="text" required value="{{ old('name') }}"
                        class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="color" class="block text-sm font-medium text-slate-700">Color</label>
                        <input id="color" name="color" type="color" value="{{ old('color', '#6366f1') }}"
                            class="mt-1 h-10 w-full rounded-lg border-slate-300 shadow-sm">
                    </div>
                    <div>
                        <label for="icon" class="block text-sm font-medium text-slate-700">Icon label</label>
                        <input id="icon" name="icon" type="text" value="{{ old('icon', 'sparkles') }}"
                            class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>
                <button type="submit" class="w-full rounded-lg bg-indigo-600 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
                    Create category
                </button>
            </form>
        </div>
    </div>
@endsection
