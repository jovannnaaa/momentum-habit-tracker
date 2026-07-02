<?php

namespace Tests\Unit;

use App\Models\Habit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HabitStreakTest extends TestCase
{
    use RefreshDatabase;

    public function test_current_streak_counts_consecutive_days_ending_today(): void
    {
        $habit = Habit::factory()->for(User::factory())->create();

        $habit->checkIns()->create(['date' => now()->toDateString()]);
        $habit->checkIns()->create(['date' => now()->subDay()->toDateString()]);
        $habit->checkIns()->create(['date' => now()->subDays(2)->toDateString()]);
        $habit->checkIns()->create(['date' => now()->subDays(5)->toDateString()]);

        $habit->refresh()->load('checkIns');

        $this->assertSame(3, $habit->currentStreak());
    }

    public function test_current_streak_is_zero_when_yesterday_and_today_are_missed(): void
    {
        $habit = Habit::factory()->for(User::factory())->create();

        $habit->checkIns()->create(['date' => now()->subDays(3)->toDateString()]);

        $habit->refresh()->load('checkIns');

        $this->assertSame(0, $habit->currentStreak());
    }

    public function test_current_streak_still_counts_if_today_not_yet_checked_in(): void
    {
        $habit = Habit::factory()->for(User::factory())->create();

        $habit->checkIns()->create(['date' => now()->subDay()->toDateString()]);
        $habit->checkIns()->create(['date' => now()->subDays(2)->toDateString()]);

        $habit->refresh()->load('checkIns');

        $this->assertSame(2, $habit->currentStreak());
    }

    public function test_longest_streak_finds_the_best_run_in_history(): void
    {
        $habit = Habit::factory()->for(User::factory())->create();

        // A 4-day run two weeks ago, and a 2-day run more recently.
        foreach ([14, 13, 12, 11] as $daysAgo) {
            $habit->checkIns()->create(['date' => now()->subDays($daysAgo)->toDateString()]);
        }
        foreach ([1, 0] as $daysAgo) {
            $habit->checkIns()->create(['date' => now()->subDays($daysAgo)->toDateString()]);
        }

        $habit->refresh()->load('checkIns');

        $this->assertSame(4, $habit->longestStreak());
    }
}
