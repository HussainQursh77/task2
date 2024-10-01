<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends Controller
{
    protected $categoryService;

    // Inject the service through the constructor
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $name = $request->input('name');
        $item_perpage = $request->input('item_perpage', 10);
        $response = $this->categoryService->allCategory($name, $item_perpage);
        return response()->json($response, $response['status'] === 'success' ? 200 : 403);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $validatedData = $request->validated();
        $response = $this->categoryService->storeCategory($validatedData);
        return response()->json($response, $response['status'] === 'success' ? 200 : 401);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $response = $this->categoryService->showCategory($id);
        return response()->json($response, $response['status'] === 'success' ? 200 : 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $respons = $this->categoryService->updatecategort($request, $id);
        return response()->json($respons, $respons['status'] === 'success' ? 200 : ($respons['message'] == 'Category not found' ? 404 : 400));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $respons = $this->categoryService->deleteCategory($id);
        return response()->json($respons, $respons['status'] === 'success' ? 200 : ($respons['message'] == 'Category not found' ? 404 : 400));
    }
}
