<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->category = Category::factory()->create();
    }

    public function test_user_can_create_task()
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/api/tasks', [
            'title' => 'Nova Tarefa',
            'category_id' => $this->category->id,
            'status' => 'pendente',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', ['title' => 'Nova Tarefa']);
    }

    public function test_user_can_list_tasks()
    {
        // Base user to use in test.
        $user = User::factory()->create();
        Task::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);

        // Other user to guarantee task will be shown.
        Task::factory()->create([
            'user_id' => User::factory()->create()->id,
        ]);

        $this->actingAs($user);
        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
        
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'category_id',
                    'status',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }

    public function test_user_can_update_task()
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user);
        $response = $this->putJson("/api/tasks/{$task->id}", [
            'title' => 'Tarefa Atualizada',
            'status' => 'concluído',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', ['title' => 'Tarefa Atualizada', 'status' => 'concluído']);
    }

    public function test_user_can_delete_task()
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user);
        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}