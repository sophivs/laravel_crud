<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;

// Rotas de autenticação
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

// Rotas protegidas (Autenticadas)
Route::middleware(['auth:sanctum'])->group(function () {
    // Rotas de Tarefas
    Route::prefix('tasks')->group(function () {
        Route::post('/', [TaskController::class, 'store']);      // Criar tarefa
        Route::get('/', [TaskController::class, 'index']);       // Listar tarefas do usuário
        Route::get('/{id}', [TaskController::class, 'show']);    // Detalhar uma tarefa específica
        Route::put('/{id}', [TaskController::class, 'update']);  // Atualizar tarefa
        Route::delete('/{id}', [TaskController::class, 'destroy']); // Remover tarefa
    });

    // Rotas de Categorias
    Route::prefix('categories')->group(function () {
        Route::post('/', [CategoryController::class, 'store']);      // Criar categoria
        Route::get('/', [CategoryController::class, 'index']);       // Listar categorias
        Route::get('/{id}', [CategoryController::class, 'show']);    // Detalhar categoria específica
        Route::put('/{id}', [CategoryController::class, 'update']);  // Atualizar categoria
        Route::delete('/{id}', [CategoryController::class, 'destroy']); // Remover categoria
    });
});
