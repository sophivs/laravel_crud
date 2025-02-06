<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Domain\Services\CategoryService;
use OpenApi\Annotations as OA;

class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct(
        CategoryService $categoryService
    ) {
        $this->categoryService = $categoryService;
    }

    /**
     * @OA\Get(
     *     path="/api/categories",
     *     summary="Get all categories",
     *     tags={"Categories"},
     *     security={
     *         {"sanctum": {}},
     *     },
     *     @OA\Response(response=200, description="List of categories")
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json($this->categoryService->getAllCategories(), 200);
    }

    /**
     * @OA\Get(
     *     path="/api/categories/{id}",
     *     summary="Get category",
     *     tags={"Categories"},
     *     security={
     *         {"sanctum": {}},
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="List of categories")
     * )
     */
    public function show($id): JsonResponse
    {
        return response()->json($this->categoryService->getCategoryById($id), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/categories",
     *     summary="Create a new category",
     *     tags={"Categories"},
     *     security={
     *         {"sanctum": {}},
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Work")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Category created successfully"),
     *     @OA\Response(response=400, description="Validation error")
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $category = $this->categoryService ->createCategory($request->all());
        return response()->json(['message' => 'Category created successfully', 'category' => $category], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/categories/{id}",
     *     summary="Update a category",
     *     tags={"Categories"},
     *     security={
     *         {"sanctum": {}},
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Updated Name")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Category updated successfully"),
     *     @OA\Response(response=404, description="Category not found")
     * )
     */
    public function update(Request $request, $id): JsonResponse
    {
        $category = $this->categoryService->updateCategory($id, $request->all());
        return response()->json(['message' => 'Category updated successfully', 'category' => $category], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/categories/{id}",
     *     summary="Delete a category",
     *     tags={"Categories"},
     *     security={
     *         {"sanctum": {}},
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Category deleted successfully"),
     *     @OA\Response(response=404, description="Category not found")
     * )
     */
    public function destroy($id): JsonResponse
    {
        $this->categoryService->deleteCategory($id);
        return response()->json(['message' => 'Category deleted successfully'], 200);
    }
}
