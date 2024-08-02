<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Http\Services\TagService;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  TagService  $tagService
     * @return \Illuminate\Http\Response
     */
    public function index(TagService $tagService)
    {
        return $tagService->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TagService  $tagService
     * @param  TagRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagService $tagService, TagRequest $request)
    {
        return $tagService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  TagService  $tagService
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(TagService $tagService, int $id)
    {
        return $tagService->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TagRequest  $request
     * @param  TagService  $tagService
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, TagService $tagService, int $id)
    {
        return $tagService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  TagService  $tagService
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TagService $tagService, int $id)
    {
        return $tagService->destroy($id);
    }
}
