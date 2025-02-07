<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AppModelsTask>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(6),
            'category_id' => Category::factory(),
            'user_id' => User::factory(),
            'status' => $this->faker->randomElement(['pendente', 'em andamento', 'concluído']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
