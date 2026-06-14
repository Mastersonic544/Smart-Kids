<?php

namespace App\Services\Meals;

use App\Models\Meal;
use App\Repositories\Meals\MealRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Service to handle business logic for Meals.
 */
class MealService
{
    protected MealRepositoryInterface $mealRepository;

    /**
     * Inject MealRepositoryInterface.
     */
    public function __construct(MealRepositoryInterface $mealRepository)
    {
        $this->mealRepository = $mealRepository;
    }

    /**
     * Get all meals records.
     */
    public function getAllMeals(): Collection
    {
        return $this->mealRepository->getAll();
    }

    /**
     * Get menu for a specific week start date.
     */
    public function getWeekMenu(string $weekStart): ?Meal
    {
        return $this->mealRepository->findByWeekStart($weekStart);
    }

    /**
     * Create a new weekly menu record.
     */
    public function createWeekMenu(array $data): Meal
    {
        // Enforce week start to be Monday
        $data['week_start'] = Carbon::parse($data['week_start'])->startOfWeek()->format('Y-m-d');

        // Add current user
        if (auth()->check()) {
            $data['created_by'] = auth()->id();
        }

        return $this->mealRepository->create($data);
    }

    /**
     * Get the menu for the current week.
     */
    public function getCurrentWeekMenu(): ?Meal
    {
        $startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d');

        return $this->mealRepository->getCurrentWeekMenu($startOfWeek);
    }
}
