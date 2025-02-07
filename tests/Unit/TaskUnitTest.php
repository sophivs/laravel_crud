<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_can_be_created()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $task = Task::create([
            'title' => 'Estudar Laravel',
            'category_id' => $category->id,
            'user_id' => $user->id,
            'status' => 'pendente',
        ]);

        $this->assertDatabaseHas('tasks', ['title' => 'Estudar Laravel']);
    }

    public function test_task_status_must_be_valid()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        Task::create([
            'title' => 'Tarefa inválida',
            'category_id' => 1,
            'user_id' => 1,
            'status' => 'inexistente'
        ]);
    }
}