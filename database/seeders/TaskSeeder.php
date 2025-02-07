<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Domain\Models\User;
use App\Domain\Models\Category;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $category = Category::first();

        if (!$user || !$category) {
            return;
        }

        DB::table('tasks')->insert([
            [
                'title' => 'Finalizar relatório',
                'category_id' => $category->id,
                'user_id' => $user->id,
                'status' => 'pendente',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Comprar presentes',
                'category_id' => $category->id,
                'user_id' => $user->id,
                'status' => 'concluído',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Estudar Laravel',
                'category_id' => $category->id,
                'user_id' => $user->id,
                'status' => 'em andamento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
