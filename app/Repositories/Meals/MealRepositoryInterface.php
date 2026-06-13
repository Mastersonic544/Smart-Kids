<?php

namespace App\Repositories\Meals;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Meal;

/**
 * Interface for Meal repository.
 */
interface MealRepositoryInterface
{
    /**
     * Get all weekly menus.
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Find a week menu by week start logic.
     *
     * @param string $weekStart
     * @return Meal|null
     */
    public function findByWeekStart(string $weekStart): ?Meal;

    /**
     * Get the current week menu.
     *
     * @param string $currentWeekStart
     * @return Meal|null
     */
    public function getCurrentWeekMenu(string $currentWeekStart): ?Meal;

    /**
     * Create a weekly menu.
     *
     * @param array $data
     * @return Meal
     */
    public function create(array $data): Meal;
}
