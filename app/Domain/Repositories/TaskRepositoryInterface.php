<?php

namespace App\Domain\Repositories;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface TaskRepositoryInterface
{
    public function create(array $data): Task;
    public function findById(int $id): ?Task;
    public function findByUserId(int $userId, Request $request);
    public function update(Task $task, array $data): Task;
    public function delete(Task $task): void;
}
