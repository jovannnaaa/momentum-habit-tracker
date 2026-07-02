<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CheckInController extends Controller
{
    /**
     * Toggle today's check-in for the given habit.
     */
    public function store(Request $request, Habit $habit): RedirectResponse
    {
        $today = now()->toDateString();

        $existing = $habit->checkIns()->whereDate('date', $today)->first();

        if ($existing) {
            $existing->delete();
        } else {
            $habit->checkIns()->create([
                'date' => $today,
                'note' => $request->input('note'),
            ]);
        }

        return back()->with('status', $existing ? 'Check-in removed.' : 'Nice! Checked in for today.');
    }
}
