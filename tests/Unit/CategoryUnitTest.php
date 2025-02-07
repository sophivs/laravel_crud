<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_can_be_created()
    {
        $category = Category::create(['name' => 'Work']);

        $this->assertDatabaseHas('categories', ['name' => 'Work']);
    }

    public function test_category_name_must_be_unique()
    {
        Category::create(['name' => 'Work']);
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        Category::create(['name' => 'Work']);
    }
}