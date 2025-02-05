<?php

namespace App\Application\UseCases\Auth;

use App\Domain\Services\AuthService;

class LoginUserUseCase
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function execute(array $credentials): array
    {
        return $this->authService->login($credentials);
    }
}
