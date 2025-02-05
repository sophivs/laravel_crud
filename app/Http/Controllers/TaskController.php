<?php

namespace App\Http\Controllers;

use App\Application\UseCases\Task\CreateTaskUseCase;
use App\Application\UseCases\Task\GetUserTasksUseCase;
use App\Application\UseCases\Task\UpdateTaskUseCase;
use App\Application\UseCases\Task\DeleteTaskUseCase;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="API de Tarefas",
 *     version="1.0.0",
 *     description="API para gerenciamento de tarefas.",
 *     @OA\Contact(
 *         email="sophiavsant@gmail.com"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 */
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

    /**
     * @OA\Post(
     *     path="/api/tasks",
     *     summary="Create a new task",
     *     tags={"Tasks"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "category_id"},
     *             @OA\Property(property="title", type="string", example="Complete project documentation"),
     *             @OA\Property(property="category_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Task created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=101),
     *             @OA\Property(property="title", type="string", example="Complete project documentation"),
     *             @OA\Property(property="category_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The title field is required.")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate(['title' => 'required|min:5', 'category_id' => 'required']);
        return response()->json($this->createTaskUseCase->execute($request->all()), 201);
    }

    /**
     * @OA\Get(
     *     path="/api/tasks",
     *     summary="Get all tasks of the authenticated user",
     *     tags={"Tasks"},
     *     @OA\Response(
     *         response=200,
     *         description="List of user tasks",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Complete project documentation"),
     *                 @OA\Property(property="category_id", type="integer", example=1)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized access",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json($this->getUserTasksUseCase->execute());
    }


    /**
     * @OA\Put(
     *     path="/api/tasks/{id}",
     *     summary="Update a task",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the task to update",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "category_id"},
     *             @OA\Property(property="title", type="string", example="Complete updated project documentation"),
     *             @OA\Property(property="category_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Complete updated project documentation"),
     *             @OA\Property(property="category_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The title field is required.")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        return response()->json($this->updateTaskUseCase->execute($id, $request->all()));
    }


    /**
     * @OA\Delete(
     *     path="/api/tasks/{id}",
     *     summary="Delete a task",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the task to delete",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Task deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Task not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Task not found")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $this->deleteTaskUseCase->execute($id);
        return response()->json(['message' => 'Tarefa deletada com sucesso']);
    }
}
