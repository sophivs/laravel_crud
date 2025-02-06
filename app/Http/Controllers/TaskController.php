<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Domain\Services\TaskService;


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
    private TaskService $taskService;

    public function __construct(
        TaskService $taskService
    ) {
        $this->taskService = $taskService;
    }

    /**
     * @OA\Post(
     *     path="/api/tasks",
     *     summary="Create a new task",
     *     tags={"Tasks"},
     *     security={
     *         {"sanctum": {}},
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "category_id"},
     *             @OA\Property(property="title", type="string", example="Complete project documentation"),
     *             @OA\Property(property="category_id", type="integer", example=1),
     *             @OA\Property(property="status", type="string", enum={"pendente", "em andamento", "concluído"}, example="pendente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Task created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=101),
     *             @OA\Property(property="title", type="string", example="Complete project documentation"),
     *             @OA\Property(property="category_id", type="integer", example=1),
     *             @OA\Property(property="status", type="string", enum={"pendente", "em andamento", "concluído"}, example="pendente")
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
        $request->validate([
            'title' => 'required|min:5',
            'category_id' => 'required',
            'status' => 'required|in:pendente,em andamento,concluído',
        ]);
        return response()->json($this->taskService->createTask($request->all()), 201);
    }

    /**
     * @OA\Get(
     *     path="/api/tasks",
     *     summary="Get all tasks of the authenticated user",
     *     tags={"Tasks"},
     *     security={ {"sanctum": {}}, },
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Filter tasks by status (pendente, em andamento, concluído)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"pendente", "em andamento", "concluído"})
     *     ),
     *     @OA\Parameter(
     *         name="category_id",
     *         in="query",
     *         description="Filter tasks by category ID",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="sort_by",
     *         in="query",
     *         description="Sort by field (default: created_at)",
     *         required=false,
     *         @OA\Schema(type="string", example="title")
     *     ),
     *     @OA\Parameter(
     *         name="sort_order",
     *         in="query",
     *         description="Sort order (asc or desc, default: desc)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"asc", "desc"})
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of tasks per page (default: 10)",
     *         required=false,
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of user tasks",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="current_page", type="integer", example=1),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="title", type="string", example="Complete project documentation"),
     *                     @OA\Property(property="category_id", type="integer", example=1),
     *                     @OA\Property(property="status", type="string", example="pendente"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-02-06T12:00:00Z")
     *                 )
     *             ),
     *             @OA\Property(property="total", type="integer", example=50),
     *             @OA\Property(property="per_page", type="integer", example=10),
     *             @OA\Property(property="last_page", type="integer", example=5)
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
    public function index(Request $request)
    {
        return response()->json($this->taskService->getUserTasks($request));
    }

    /**
     * @OA\Get(
     *     path="/api/tasks/{id}",
     *     summary="Get a task of the authenticated user",
     *     tags={"Tasks"},
     *     security={
     *         {"sanctum": {}},
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User task",
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
    public function show($id)
    {
        return response()->json($this->taskService->getUserTask($id));
    }

    /**
     * @OA\Put(
     *     path="/api/tasks/{id}",
     *     summary="Update a task",
     *     tags={"Tasks"},
     *     security={
     *         {"sanctum": {}},
     *     },
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
     *             @OA\Property(property="category_id", type="integer", example=1),
     *             @OA\Property(property="status", type="string", enum={"pendente", "em andamento", "concluído"}, example="pendente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Complete updated project documentation"),
     *             @OA\Property(property="category_id", type="integer", example=1),
     *             @OA\Property(property="status", type="string", enum={"pendente", "em andamento", "concluído"}, example="pendente")
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
        $request->validate([
            'title' => 'min:5',
            'status' => 'in:pendente,em andamento,concluído',
        ]);
        return response()->json($this->taskService->updateTask($id, $request->all()));
    }


    /**
     * @OA\Delete(
     *     path="/api/tasks/{id}",
     *     summary="Delete a task",
     *     tags={"Tasks"},
     *     security={
     *         {"sanctum": {}},
     *     },
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
        $this->taskService->deleteTask($id);
        return response()->json(['message' => 'Tarefa deletada com sucesso']);
    }
}
