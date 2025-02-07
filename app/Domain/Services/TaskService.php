<?php

namespace App\Domain\Services;

use App\Domain\Repositories\TaskRepositoryInterface;
use App\Domain\Models\Task;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TaskService
{
    protected TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function createTask(array $data): ?Task
    {
        try {
            $data['user_id'] = Auth::id();
            return $this->taskRepository->create($data);
        } catch (QueryException $e) {
            throw ValidationException::withMessages(['error' => 'Verifique se a categoria inserida existe']);
        }
    }

    public function getUserTasks(Request $request): array
    {
        return $this->taskRepository->findByUserId(Auth::id(), $request)->toArray();
    }

    public function getUserTask($id): Task
    {
        $task = $this->taskRepository->findById($id);

        if (!$task || !$task->isOwnedBy(Auth::id())) {
            throw ValidationException::withMessages(['error' => 'Tarefa não encontrada ou acesso negado']);
        }

        return $task;

    }

    public function updateTask(int $id, array $data): Task
    {
        $task = $this->taskRepository->findById($id);

        if (!$task || !$task->isOwnedBy(Auth::id())) {
            throw ValidationException::withMessages(['error' => 'Tarefa não encontrada ou acesso negado']);
        }

        try {
            return $this->taskRepository->update($task, $data);
        } catch (QueryException $e) {
            throw ValidationException::withMessages(['error' => 'Verifique se a categoria inserida existe']);
        }
    }

    public function deleteTask(int $id): void
    {
        $task = $this->taskRepository->findById($id);

        if (!$task || !$task->isOwnedBy(Auth::id())) {
            throw ValidationException::withMessages(['error' => 'Tarefa não encontrada ou acesso negado']);
        }

        $this->taskRepository->delete($task);
    }
}
