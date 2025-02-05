<?php

namespace App\Application\UseCases\Auth;

use App\Domain\Services\AuthService;

class RegisterUserUseCase
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function execute(array $data): array
    {
        return $this->authService->register($data);
    }
}
