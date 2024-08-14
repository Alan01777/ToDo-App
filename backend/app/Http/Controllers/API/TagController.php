<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Services\TagService;
use Illuminate\Http\Request;

class TagController extends Controller
{
    protected $tagService;

    /**
     * Create a new TagController instance.
     *
     * @param  TagService  $tagService
     * @return void
     */
    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  TagService  $tagService
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return $this->tagService->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TagRequest  $request
     * @return \App\Http\Resources\TagResource
     */
    public function store(TagRequest $request)
    {
        return $this->tagService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \App\Http\Resources\TagResource
     */
    public function show(int $id)
    {
        return $this->tagService->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TagRequest  $request
     * @param  int  $id
     * @return \App\Http\Resources\TagResource
     */
    public function update(TagRequest $request, int $id)
    {
        return $this->tagService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return null
     */
    public function destroy(int $id)
    {
        return $this->tagService->destroy($id);
    }
}
