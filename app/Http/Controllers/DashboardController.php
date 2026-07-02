<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $habits = $request->user()->habits()
            ->with(['category', 'checkIns'])
            ->where('is_archived', false)
            ->get();

        $totalHabits = $habits->count();
        $checkedInToday = $habits->filter(fn ($h) => $h->isCheckedInToday())->count();
        $longestActiveStreak = $habits->max(fn ($h) => $h->currentStreak()) ?? 0;
        $avgCompletion = $totalHabits
            ? (int) round($habits->avg(fn ($h) => $h->completionRate(30)))
            : 0;

        return view('dashboard.index', [
            'habits' => $habits->sortByDesc(fn ($h) => $h->currentStreak())->values(),
            'totalHabits' => $totalHabits,
            'checkedInToday' => $checkedInToday,
            'longestActiveStreak' => $longestActiveStreak,
            'avgCompletion' => $avgCompletion,
        ]);
    }
}
