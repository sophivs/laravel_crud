<?php

namespace App\Http\Controllers;

use App\Application\UseCases\Auth\RegisterUserUseCase;
use App\Application\UseCases\Auth\LoginUserUseCase;
use App\Application\UseCases\Auth\LogoutUserUseCase;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private RegisterUserUseCase $registerUserUseCase;
    private LoginUserUseCase $loginUserUseCase;
    private LogoutUserUseCase $logoutUserUseCase;

    public function __construct(
        RegisterUserUseCase $registerUserUseCase,
        LoginUserUseCase $loginUserUseCase,
        LogoutUserUseCase $logoutUserUseCase
    ) {
        $this->registerUserUseCase = $registerUserUseCase;
        $this->loginUserUseCase = $loginUserUseCase;
        $this->logoutUserUseCase = $logoutUserUseCase;
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        return response()->json($this->registerUserUseCase->execute($request->all()), 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        return response()->json($this->loginUserUseCase->execute($request->all()));
    }

    public function logout(Request $request)
    {
        $this->logoutUserUseCase->execute($request->user());
        return response()->json(['message' => 'Logout realizado com sucesso']);
    }
}
