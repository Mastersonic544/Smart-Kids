<?php

namespace App\Repositories\Meals;

use App\Models\Meal;
use Illuminate\Database\Eloquent\Collection;

/**
 * Repository to handle database operations for Meals.
 */
class MealRepository implements MealRepositoryInterface
{
    public function getAll(): Collection
    {
        return Meal::orderBy('week_start', 'desc')->get();
    }

    public function findByWeekStart(string $weekStart): ?Meal
    {
        return Meal::where('week_start', $weekStart)->first();
    }

    public function getCurrentWeekMenu(string $currentWeekStart): ?Meal
    {
        return Meal::where('week_start', '<=', $currentWeekStart)
            ->orderBy('week_start', 'desc')
            ->first();
    }

    public function create(array $data): Meal
    {
        return Meal::create($data);
    }
}
