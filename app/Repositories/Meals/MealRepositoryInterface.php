<?php

namespace App\Repositories\Meals;

use App\Models\Meal;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface for Meal repository.
 */
interface MealRepositoryInterface
{
    /**
     * Get all weekly menus.
     */
    public function getAll(): Collection;

    /**
     * Find a week menu by week start logic.
     */
    public function findByWeekStart(string $weekStart): ?Meal;

    /**
     * Get the current week menu.
     */
    public function getCurrentWeekMenu(string $currentWeekStart): ?Meal;

    /**
     * Create a weekly menu.
     */
    public function create(array $data): Meal;
}
