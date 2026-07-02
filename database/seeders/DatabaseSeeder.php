<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CheckIn;
use App\Models\Habit;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Demo User',
            'email' => 'demo@momentum.test',
            'password' => bcrypt('password'),
        ]);

        $categories = [
            ['name' => 'Health', 'color' => '#22c55e', 'icon' => 'heart'],
            ['name' => 'Learning', 'color' => '#6366f1', 'icon' => 'book'],
            ['name' => 'Mindfulness', 'color' => '#a855f7', 'icon' => 'brain'],
        ];

        $categoryModels = collect($categories)->map(
            fn ($c) => Category::create([...$c, 'user_id' => $user->id])
        );

        $habits = [
            ['name' => 'Drink 2L of water', 'category' => 'Health', 'frequency' => 'daily', 'target' => 7],
            ['name' => 'Read for 20 minutes', 'category' => 'Learning', 'frequency' => 'daily', 'target' => 7],
            ['name' => 'Meditate', 'category' => 'Mindfulness', 'frequency' => 'daily', 'target' => 5],
            ['name' => 'Go for a run', 'category' => 'Health', 'frequency' => 'weekly', 'target' => 3],
        ];

        foreach ($habits as $data) {
            $category = $categoryModels->firstWhere('name', $data['category']);

            $habit = Habit::create([
                'user_id' => $user->id,
                'category_id' => $category->id,
                'name' => $data['name'],
                'description' => 'Auto-generated demo habit to showcase Momentum.',
                'frequency' => $data['frequency'],
                'target_per_week' => $data['target'],
            ]);

            // Seed the last 21 days with a realistic, mostly-consistent streak.
            for ($i = 20; $i >= 0; $i--) {
                $date = now()->subDays($i);

                // Skip roughly 1 in 5 days to make the streak look organic,
                // but always check in today and yesterday for a live streak.
                if ($i > 1 && random_int(1, 5) === 1) {
                    continue;
                }

                CheckIn::create([
                    'habit_id' => $habit->id,
                    'date' => $date->toDateString(),
                ]);
            }
        }
    }
}
