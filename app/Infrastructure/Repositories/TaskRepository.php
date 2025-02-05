<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\TaskRepositoryInterface;
use App\Domain\Models\Task;
use Illuminate\Support\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function findById(int $id): ?Task
    {
        return Task::find($id);
    }

    public function findByUserId(int $userId): Collection
    {
        return Task::where('user_id', $userId)->get();
    }

    public function update(Task $task, array $data): Task
    {
        $task->update($data);
        return $task;
    }

    public function delete(Task $task): void
    {
        $task->delete();
    }
}
