<?php

namespace App\Domain\Services;

use App\Domain\Repositories\CategoryRepositoryInterface;
use App\Domain\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CategoryService
{
    protected CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function createCategory(array $data): Category
    {
        return $this->categoryRepository->create($data);
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->getAll();
    }

    public function getCategoryById(int $id)
    {
        $category = $this->categoryRepository->findById($id);

        if (!$category) {
            throw ValidationException::withMessages(['error' => 'Categoria não encontrada']);
        }
        
        return $category;
    }

    public function updateCategory(int $id, array $data): Category
    {
        $category = $this->categoryRepository->findById($id);

        if (!$category) {
            throw ValidationException::withMessages(['error' => 'Categoria não encontrada']);
        }

        return $this->categoryRepository->update($category, $data);
    }

    public function deleteCategory(int $id): void
    {
        $category = $this->categoryRepository->findById($id);

        if (!$category) {
            throw ValidationException::withMessages(['error' => 'Categoria não encontrada']);
        }

        $this->categoryRepository->delete($id);
    }
}
