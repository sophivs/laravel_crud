<?php

namespace App\Http\Controllers;

use App\Application\UseCases\Task\CreateTaskUseCase;
use App\Application\UseCases\Task\GetUserTasksUseCase;
use App\Application\UseCases\Task\UpdateTaskUseCase;
use App\Application\UseCases\Task\DeleteTaskUseCase;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private CreateTaskUseCase $createTaskUseCase;
    private GetUserTasksUseCase $getUserTasksUseCase;
    private UpdateTaskUseCase $updateTaskUseCase;
    private DeleteTaskUseCase $deleteTaskUseCase;

    public function __construct(
        CreateTaskUseCase $createTaskUseCase,
        GetUserTasksUseCase $getUserTasksUseCase,
        UpdateTaskUseCase $updateTaskUseCase,
        DeleteTaskUseCase $deleteTaskUseCase
    ) {
        $this->createTaskUseCase = $createTaskUseCase;
        $this->getUserTasksUseCase = $getUserTasksUseCase;
        $this->updateTaskUseCase = $updateTaskUseCase;
        $this->deleteTaskUseCase = $deleteTaskUseCase;
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required|min:5', 'category_id' => 'required']);
        return response()->json($this->createTaskUseCase->execute($request->all()), 201);
    }

    public function index()
    {
        return response()->json($this->getUserTasksUseCase->execute());
    }

    public function update(Request $request, $id)
    {
        return response()->json($this->updateTaskUseCase->execute($id, $request->all()));
    }

    public function destroy($id)
    {
        $this->deleteTaskUseCase->execute($id);
        return response()->json(['message' => 'Tarefa deletada com sucesso']);
    }
}
