<?php

namespace App\Providers;

use App\Repositories\Activities\ActivityRepository;
use App\Repositories\Activities\ActivityRepositoryInterface;
use App\Repositories\Children\ChildRepository;
use App\Repositories\Children\ChildRepositoryInterface;
use App\Repositories\Meals\MealRepository;
use App\Repositories\Meals\MealRepositoryInterface;
use App\Repositories\Teachers\TeacherRepository;
use App\Repositories\Teachers\TeacherRepositoryInterface;
use Illuminate\Support\ServiceProvider;

/**
 * Service provider to bind interfaces to concrete implementations.
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ChildRepositoryInterface::class, ChildRepository::class);
        $this->app->bind(TeacherRepositoryInterface::class, TeacherRepository::class);
        $this->app->bind(ActivityRepositoryInterface::class, ActivityRepository::class);
        $this->app->bind(MealRepositoryInterface::class, MealRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
