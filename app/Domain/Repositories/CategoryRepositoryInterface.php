<?php

namespace App\Domain\Repositories;

use App\Domain\Models\Category;

interface CategoryRepositoryInterface
{
    public function getAll();
    public function create(array $data): Category;
    public function update(Category $category, array $data): Category;
    public function delete(int $id): void;
}
