<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Repositories\TaskRepositoryInterface;
use App\Domain\Repositories\CategoryRepositoryInterface;
use App\Infrastructure\Repositories\UserRepository;
use App\Infrastructure\Repositories\TaskRepository;
use App\Infrastructure\Repositories\CategoryRepository;
use App\Domain\Services\AuthService;
use App\Domain\Services\TaskService;
use App\Domain\Services\CategoryService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind Repositories
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);

        // Bind Services
        $this->app->singleton(AuthService::class);
        $this->app->singleton(TaskService::class, function ($app) {
            return new TaskService($app->make(TaskRepositoryInterface::class));
        });
        $this->app->singleton(CategoryService::class, function ($app) {
            return new CategoryService($app->make(CategoryRepositoryInterface::class));
        });
    }

    public function boot(): void
    {
        // Bootstrap any application services
    }
}