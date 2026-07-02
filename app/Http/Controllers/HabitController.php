<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HabitController extends Controller
{
    public function index(Request $request): View
    {
        $habits = $request->user()->habits()
            ->with(['category', 'checkIns'])
            ->orderBy('is_archived')
            ->orderByDesc('created_at')
            ->get();

        return view('habits.index', ['habits' => $habits]);
    }

    public function create(Request $request): View
    {
        $categories = $request->user()->categories()->orderBy('name')->get();

        return view('habits.create', ['categories' => $categories]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);

        $habit = $request->user()->habits()->create($validated);

        return redirect()->route('habits.show', $habit)->with('status', 'Habit created. Let\'s build some momentum!');
    }

    public function show(Habit $habit): View
    {
        $habit->load(['category', 'checkIns' => fn ($q) => $q->orderByDesc('date')]);

        return view('habits.show', ['habit' => $habit]);
    }

    public function edit(Request $request, Habit $habit): View
    {
        $categories = $request->user()->categories()->orderBy('name')->get();

        return view('habits.edit', ['habit' => $habit, 'categories' => $categories]);
    }

    public function update(Request $request, Habit $habit): RedirectResponse
    {
        $validated = $this->validated($request);

        $habit->update($validated);

        return redirect()->route('habits.show', $habit)->with('status', 'Habit updated.');
    }

    public function destroy(Habit $habit): RedirectResponse
    {
        $habit->delete();

        return redirect()->route('habits.index')->with('status', 'Habit deleted.');
    }

    public function archive(Habit $habit): RedirectResponse
    {
        $habit->update(['is_archived' => ! $habit->is_archived]);

        return back()->with('status', $habit->is_archived ? 'Habit archived.' : 'Habit restored.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'frequency' => ['required', 'in:daily,weekly'],
            'target_per_week' => ['required', 'integer', 'min:1', 'max:7'],
        ]);
    }
}
