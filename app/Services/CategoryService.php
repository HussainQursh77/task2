<?php

namespace App\Services;
use App\Models\Category;
use Database\Factories\CategoryFactory;
use Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Illuminate\Database\Eloquent\ModelNotFoundException;
class CategoryService
{

    public function allCategory($name, $item_perpage = 10)
    {

        try {
            $category = Category::byName($name)->orderBy('created_at', 'DESC')->paginate($item_perpage);
            return [
                'status' => 'success',
                'message' => 'all categories',
                'data' => $category
            ];
        } catch (\Exception $e) {
            log::error('Error get all category' . $e->getMessage());
            return [
                'status' => 'fiald',
                'message' => 'fiald fetch all categories',
                'data' => null
            ];
        }
    }

    public function storeCategory($data)
    {
        try {
            $category = Category::create(
                [
                    'name' => $data['name'],
                ]
            );
            return [
                'status' => 'success',
                'message' => 'store category succesfuly',
                'data' => $category->only('name')
            ];
        } catch (\Exception $e) {
            log::error('Error store category' . $e->getMessage());
            return [
                'status' => 'faild',
                'message' => 'store category faild',
                'data' => null
            ];
        }
    }

    public function showCategory($data)
    {
        try {
            $category = Category::findOrFail($data)->load('books');
            return [
                'status' => 'success',
                'message' => 'Category with books',
                'data' => $category
            ];
        } catch (ModelNotFoundException $e) {
            return [
                'status' => 'failed',
                'message' => 'Category not found',
                'data' => null
            ];
        }
    }

    public function updatecategort($data, $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->update([
                'name' => $data['name'],
            ]);
            return [
                'status' => 'success',
                'message' => 'Category updated succesfuly',
                'data' => $category
            ];
        } catch (ModelNotFoundException $e) {
            return [
                'status' => 'failed',
                'message' => 'Category not found',
                'data' => null
            ];
        } catch (\Exception $e) {
            log::error('Error updated category ' . $e->getMessage());
            return [
                'status' => 'failed',
                'message' => 'some error occuerd when updated category',
                'data' => null
            ];
        }
    }
    public function deleteCategory($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return [
                'status' => 'success',
                'message' => 'category deleted succesfuly',
                'data' => null
            ];
        } catch (ModelNotFoundException $e) {
            return [
                'status' => 'failed',
                'message' => 'Category not found',
                'data' => null
            ];
        } catch (\Exception $e) {
            log::error('Error deleted category ' . $e->getMessage());
            return [
                'status' => 'failed',
                'message' => 'some error occuerd when delete category',
                'data' => null
            ];
        }
    }
}
