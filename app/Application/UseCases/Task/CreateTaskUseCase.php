<?php

namespace App\Application\UseCases\Task;

use App\Domain\Services\TaskService;

class CreateTaskUseCase
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function execute(array $data)
    {
        return $this->taskService->createTask($data);
    }
}
