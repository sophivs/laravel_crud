<?php

namespace App\Application\UseCases\Auth;

use App\Domain\Services\AuthService;

class LogoutUserUseCase
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function execute($user): void
    {
        $this->authService->logout($user);
    }
}
