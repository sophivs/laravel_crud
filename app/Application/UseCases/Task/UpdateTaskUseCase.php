<?php

namespace App\Application\UseCases\Task;

use App\Domain\Services\TaskService;

class UpdateTaskUseCase
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function execute(int $id, array $data)
    {
        return $this->taskService->updateTask($id, $data);
    }
}
