<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryTreeResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $perPage = request('per_page', 10);
        // $search = request('search', '');
        $sortField = request('sort_field', 'name');
        $sortDirection = request('sort_direction', default: 'asc');

        $categories = Category::query()
            ->orderBy("categories.$sortField", $sortDirection)->get();
        // if ($search) {
        //     $query->where('name', 'like', "%{$search}%");
        // }
        // $paginator = $query->paginate($perPage);
        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;
        $category = Category::create($data);
        return new CategoryResource($category);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;
        $category->update($data);
        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->noContent();
    }

    public function getAsTree()
    {
        return $categories = Category::getActiveAsTree(CategoryTreeResource::class);
        // return CategoryResource::collection($categories);
    }
}
