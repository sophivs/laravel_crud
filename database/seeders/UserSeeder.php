<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => '123456',
        ]);

        User::create([
            'name' => 'User Test',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}

