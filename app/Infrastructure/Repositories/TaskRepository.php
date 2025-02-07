<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Http\Request;
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

    public function findByUserId(int $userId, Request $request)
    {
        $query = Task::where('user_id', $userId);

        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->has('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');

        $query->orderBy($sortBy, $sortOrder);

        $perPage = $request->input('per_page', 10);

        return $query->paginate($perPage);
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
