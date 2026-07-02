<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Habit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'description',
        'frequency',
        'target_per_week',
        'is_archived',
    ];

    protected function casts(): array
    {
        return [
            'is_archived' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function checkIns(): HasMany
    {
        return $this->hasMany(CheckIn::class);
    }

    public function isCheckedInOn(Carbon|string $date): bool
    {
        $date = Carbon::parse($date)->toDateString();

        return $this->checkIns->contains(fn (CheckIn $checkIn) => $checkIn->date->toDateString() === $date);
    }

    public function isCheckedInToday(): bool
    {
        return $this->isCheckedInOn(now());
    }

    /**
     * Current streak of consecutive days checked in, ending today or yesterday.
     */
    public function currentStreak(): int
    {
        $dates = $this->checkIns->pluck('date')->map(fn ($d) => $d->toDateString())->sort()->values();

        if ($dates->isEmpty()) {
            return 0;
        }

        $today = Carbon::today();
        $cursor = $dates->contains($today->toDateString())
            ? $today->copy()
            : ($dates->contains($today->copy()->subDay()->toDateString()) ? $today->copy()->subDay() : null);

        if (! $cursor) {
            return 0;
        }

        $streak = 0;
        $dateSet = $dates->flip();

        while ($dateSet->has($cursor->toDateString())) {
            $streak++;
            $cursor->subDay();
        }

        return $streak;
    }

    /**
     * Longest streak of consecutive check-in days ever recorded.
     */
    public function longestStreak(): int
    {
        $dates = $this->checkIns->pluck('date')->map(fn ($d) => Carbon::parse($d))->sort()->values();

        if ($dates->isEmpty()) {
            return 0;
        }

        $longest = 1;
        $current = 1;

        for ($i = 1; $i < $dates->count(); $i++) {
            if ($dates[$i]->diffInDays($dates[$i - 1]) === 1) {
                $current++;
            } else {
                $current = 1;
            }

            $longest = max($longest, $current);
        }

        return $longest;
    }

    /**
     * Completion rate over the last N days, as a percentage.
     */
    public function completionRate(int $days = 30): int
    {
        $since = Carbon::today()->subDays($days - 1);

        $completed = $this->checkIns
            ->filter(fn (CheckIn $c) => $c->date->greaterThanOrEqualTo($since))
            ->count();

        return (int) round(min(100, ($completed / $days) * 100));
    }
}
