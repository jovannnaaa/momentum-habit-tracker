@php
    $checkedInToday = $habit->isCheckedInToday();
    $streak = $habit->currentStreak();
@endphp

<div class="flex items-center justify-between gap-4 rounded-xl border border-slate-200 bg-white p-4 {{ $habit->is_archived ? 'opacity-60' : '' }}">
    <div class="min-w-0 flex-1">
        <a href="{{ route('habits.show', $habit) }}" class="font-semibold text-slate-900 hover:text-indigo-600">
            {{ $habit->name }}
        </a>
        <div class="mt-1 flex flex-wrap items-center gap-2 text-xs text-slate-500">
            @if ($habit->category)
                <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5" style="background-color: {{ $habit->category->color }}20; color: {{ $habit->category->color }}">
                    {{ $habit->category->name }}
                </span>
            @endif
            <span class="capitalize">{{ $habit->frequency }}</span>
            <span>&middot;</span>
            <span>🔥 {{ $streak }} day{{ $streak === 1 ? '' : 's' }} streak</span>
        </div>
    </div>

    <form method="POST" action="{{ route('habits.check-in', $habit) }}">
        @csrf
        <button type="submit"
            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full border-2 text-lg transition
                {{ $checkedInToday ? 'border-emerald-500 bg-emerald-500 text-white' : 'border-slate-300 text-slate-300 hover:border-indigo-400 hover:text-indigo-400' }}">
            ✓
        </button>
    </form>
</div>
