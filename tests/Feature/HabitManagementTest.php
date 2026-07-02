<?php

namespace Tests\Feature;

use App\Models\Habit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HabitManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_create_a_habit(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/habits', [
            'name' => 'Drink water',
            'frequency' => 'daily',
            'target_per_week' => 7,
        ]);

        $this->assertDatabaseHas('habits', [
            'user_id' => $user->id,
            'name' => 'Drink water',
        ]);

        $habit = Habit::first();
        $response->assertRedirect(route('habits.show', $habit));
    }

    public function test_a_user_cannot_view_another_users_habit(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();
        $habit = Habit::factory()->for($owner)->create();

        $this->actingAs($intruder)
            ->get(route('habits.show', $habit))
            ->assertForbidden();
    }

    public function test_checking_in_creates_a_check_in_for_today(): void
    {
        $user = User::factory()->create();
        $habit = Habit::factory()->for($user)->create();

        $this->actingAs($user)->post(route('habits.check-in', $habit));

        $this->assertDatabaseHas('check_ins', [
            'habit_id' => $habit->id,
            'date' => now()->toDateString(),
        ]);
    }

    public function test_checking_in_twice_removes_the_check_in(): void
    {
        $user = User::factory()->create();
        $habit = Habit::factory()->for($user)->create();

        $this->actingAs($user)->post(route('habits.check-in', $habit));
        $this->actingAs($user)->post(route('habits.check-in', $habit));

        $this->assertDatabaseCount('check_ins', 0);
    }

    public function test_a_user_can_delete_their_own_habit(): void
    {
        $user = User::factory()->create();
        $habit = Habit::factory()->for($user)->create();

        $this->actingAs($user)->delete(route('habits.destroy', $habit));

        $this->assertDatabaseMissing('habits', ['id' => $habit->id]);
    }
}
