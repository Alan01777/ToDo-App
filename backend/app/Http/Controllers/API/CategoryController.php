<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Services\CategoryService  $categoryService
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(CategoryService $categoryService)
    {
        return $categoryService->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Services\CategoryService  $categoryService
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @return App\Http\Resources\CategoryResource
     */
    public function store(CategoryService $categoryService, CategoryRequest $request)
    {
        return $categoryService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Services\CategoryService  $categoryService
     * @param  int  $id
     * @return \App\Http\Resources\CategoryResource
     */
    public function show(CategoryService $categoryService, int $id)
    {
        return $categoryService->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @param  \App\Http\Services\CategoryService  $categoryService
     * @param  int  $id
     * @return \App\Http\Resources\CategoryResource
     */
    public function update(CategoryRequest $request, CategoryService $categoryService, int $id)
    {
        return $categoryService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Services\CategoryService  $categoryService
     * @param  int  $id
     * @return null
     */
    public function destroy(CategoryService $categoryService, int $id)
    {
        return $categoryService->destroy($id);
    }
}
