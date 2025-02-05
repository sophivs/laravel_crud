<?php

namespace App\Domain\Repositories;

use App\Domain\Models\Task;
use Illuminate\Support\Collection;

interface TaskRepositoryInterface
{
    public function create(array $data): Task;
    public function findById(int $id): ?Task;
    public function findByUserId(int $userId): Collection;
    public function update(Task $task, array $data): Task;
    public function delete(Task $task): void;
}
