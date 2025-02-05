<?php

namespace App\Application\UseCases\Task;

use App\Domain\Services\TaskService;

class GetUserTasksUseCase
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function execute()
    {
        return $this->taskService->getUserTasks();
    }
}
