<?php

namespace App\Domain\Services;

use App\Domain\Repositories\TaskRepositoryInterface;
use App\Domain\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TaskService
{
    protected TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function createTask(array $data): Task
    {
        $data['user_id'] = Auth::id();
        return $this->taskRepository->create($data);
    }

    public function getUserTasks(): array
    {
        return $this->taskRepository->findByUserId(Auth::id())->toArray();
    }

    public function updateTask(int $id, array $data): Task
    {
        $task = $this->taskRepository->findById($id);

        if (!$task || !$task->isOwnedBy(Auth::id())) {
            throw ValidationException::withMessages(['error' => 'Tarefa não encontrada ou acesso negado']);
        }

        return $this->taskRepository->update($task, $data);
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
