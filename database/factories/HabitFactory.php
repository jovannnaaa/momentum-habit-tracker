<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Habit>
 */
class HabitFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'name' => fake()->unique()->sentence(3),
            'description' => fake()->optional()->sentence(10),
            'frequency' => fake()->randomElement(['daily', 'weekly']),
            'target_per_week' => fake()->numberBetween(1, 7),
            'is_archived' => false,
        ];
    }
}
