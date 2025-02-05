<?php

namespace App\Providers;

use App\Domain\Repositories\UserRepositoryInterface;
use App\Infrastructure\Repositories\UserRepository;
use App\Domain\Services\AuthService;
use App\Application\UseCases\Auth\RegisterUserUseCase;
use App\Application\UseCases\Auth\LoginUserUseCase;
use App\Application\UseCases\Auth\LogoutUserUseCase;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(AuthService::class);
        $this->app->singleton(RegisterUserUseCase::class);
        $this->app->singleton(LoginUserUseCase::class);
        $this->app->singleton(LogoutUserUseCase::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
