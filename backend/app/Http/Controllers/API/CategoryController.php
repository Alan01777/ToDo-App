<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Exceptions\NullValueException;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;


    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     * @throws NullValueException
     */
    public function index(): AnonymousResourceCollection
    {
        return $this->categoryService->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request
     * @return CategoryResource
     */
    public function store(CategoryRequest $request): CategoryResource
    {
        return $this->categoryService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return CategoryResource
     * @throws NullValueException
     */
    public function show(int $id): CategoryResource
    {
        return $this->categoryService->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryRequest $request The request sent by the user
     * @param int $id The id of the category to Update
     * @return CategoryResource
     * @throws NullValueException
     */
    public function update(CategoryRequest $request, int $id): CategoryResource
    {
        return $this->categoryService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     * @throws NullValueException
     */
    public function destroy(int $id): Response
    {
        $this->categoryService->destroy($id);
        return response()->noContent();
    }
}
