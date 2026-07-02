<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $categories = $request->user()->categories()->withCount('habits')->orderBy('name')->get();

        return view('categories.index', ['categories' => $categories]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'color' => ['required', 'string', 'max:7'],
            'icon' => ['required', 'string', 'max:32'],
        ]);

        $request->user()->categories()->create($validated);

        return back()->with('status', 'Category created.');
    }

    public function destroy(Request $request, \App\Models\Category $category): RedirectResponse
    {
        abort_unless($category->user_id === $request->user()->id, 403);

        $category->delete();

        return back()->with('status', 'Category deleted.');
    }
}
