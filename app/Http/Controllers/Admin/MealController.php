<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Meals\StoreMealRequest;
use App\Services\Meals\MealService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MealController extends Controller
{
    protected MealService $mealService;

    public function __construct(MealService $mealService)
    {
        $this->mealService = $mealService;
    }

    public function index(): View
    {
        $meals = $this->mealService->getAllMeals();

        return view('admin.meals.index', compact('meals'));
    }

    public function create(): View
    {
        return view('admin.meals.create');
    }

    public function store(StoreMealRequest $request): RedirectResponse
    {
        $this->mealService->createWeekMenu($request->validated());

        return redirect()->route('admin.meals.index')->with('success', 'Menu de la semaine créé avec succès.');
    }

    public function show(string $weekStart): View
    {
        $meal = $this->mealService->getWeekMenu($weekStart);
        if (! $meal) {
            abort(404);
        }

        return view('admin.meals.show', compact('meal'));
    }
}
