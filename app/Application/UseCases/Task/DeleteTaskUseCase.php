<?php

namespace App\Application\UseCases\Task;

use App\Domain\Services\TaskService;

class DeleteTaskUseCase
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function execute(int $id)
    {
        $this->taskService->deleteTask($id);
    }
}
