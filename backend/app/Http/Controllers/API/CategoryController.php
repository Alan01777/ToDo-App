<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    /**
     * Create a new CategoryController instance.
     *
     * @param  \App\Services\CategoryService  $categoryService
     * @return void
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Services\CategoryService  $categoryService
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return $this->categoryService->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @return \App\Http\Resources\CategoryResource
     */
    public function store(CategoryRequest $request)
    {
        return $this->categoryService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \App\Http\Resources\CategoryResource
     */
    public function show(int $id)
    {
        return $this->categoryService->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @param  int  $id
     * @return \App\Http\Resources\CategoryResource
     */
    public function update(CategoryRequest $request, int $id)
    {
        return $this->categoryService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return null
     */
    public function destroy(int $id)
    {
        return $this->categoryService->destroy($id);
    }
}
