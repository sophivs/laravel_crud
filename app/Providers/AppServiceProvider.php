<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Repositories\TaskRepositoryInterface;
use App\Infrastructure\Repositories\TaskRepository;
use App\Infrastructure\Repositories\UserRepository;
use App\Domain\Services\TaskService;
use App\Domain\Services\AuthService;
use App\Application\UseCases\Auth\RegisterUserUseCase;
use App\Application\UseCases\Auth\LoginUserUseCase;
use App\Application\UseCases\Auth\LogoutUserUseCase;
use App\Application\UseCases\Task\CreateTaskUseCase;
use App\Application\UseCases\Task\GetUserTasksUseCase;
use App\Application\UseCases\Task\UpdateTaskUseCase;
use App\Application\UseCases\Task\DeleteTaskUseCase;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind Repositories
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);

        // Bind Services
        $this->app->singleton(AuthService::class);
        $this->app->singleton(TaskService::class, function ($app) {
            return new TaskService($app->make(TaskRepositoryInterface::class));
        });

        // Bind Use Cases
        $this->app->singleton(RegisterUserUseCase::class);
        $this->app->singleton(LoginUserUseCase::class);
        $this->app->singleton(LogoutUserUseCase::class);

        $this->app->singleton(CreateTaskUseCase::class, function ($app) {
            return new CreateTaskUseCase($app->make(TaskService::class));
        });

        $this->app->singleton(GetUserTasksUseCase::class, function ($app) {
            return new GetUserTasksUseCase($app->make(TaskService::class));
        });

        $this->app->singleton(UpdateTaskUseCase::class, function ($app) {
            return new UpdateTaskUseCase($app->make(TaskService::class));
        });

        $this->app->singleton(DeleteTaskUseCase::class, function ($app) {
            return new DeleteTaskUseCase($app->make(TaskService::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
