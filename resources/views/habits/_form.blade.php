@php
    $h = $habit ?? null;
@endphp

<div>
    <label for="name" class="block text-sm font-medium text-slate-700">Name</label>
    <input id="name" name="name" type="text" required value="{{ old('name', $h?->name) }}"
        class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        placeholder="e.g. Read for 20 minutes">
</div>

<div>
    <label for="description" class="block text-sm font-medium text-slate-700">Description <span class="text-slate-400">(optional)</span></label>
    <textarea id="description" name="description" rows="2"
        class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $h?->description) }}</textarea>
</div>

<div>
    <label for="category_id" class="block text-sm font-medium text-slate-700">Category <span class="text-slate-400">(optional)</span></label>
    <select id="category_id" name="category_id"
        class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <option value="">No category</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" @selected(old('category_id', $h?->category_id) == $category->id)>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label for="frequency" class="block text-sm font-medium text-slate-700">Frequency</label>
        <select id="frequency" name="frequency"
            class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="daily" @selected(old('frequency', $h?->frequency ?? 'daily') === 'daily')>Daily</option>
            <option value="weekly" @selected(old('frequency', $h?->frequency) === 'weekly')>Weekly</option>
        </select>
    </div>

    <div>
        <label for="target_per_week" class="block text-sm font-medium text-slate-700">Target / week</label>
        <input id="target_per_week" name="target_per_week" type="number" min="1" max="7"
            value="{{ old('target_per_week', $h?->target_per_week ?? 7) }}"
            class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
    </div>
</div>
