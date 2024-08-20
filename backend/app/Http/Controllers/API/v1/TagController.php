<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Exceptions\NullValueException;
use App\Http\Requests\v1\TagRequest;
use App\Http\Resources\v1\TagResource;
use App\Services\Resources\TagService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TagController extends Controller
{
    protected TagService $tagService;


    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     * @throws NullValueException
     */
    public function index(): AnonymousResourceCollection
    {
        return $this->tagService->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TagRequest  $request
     * @return \App\Http\Resources\v1\TagResource
     */
    public function store(TagRequest $request): TagResource
    {
        return $this->tagService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \App\Http\Resources\v1\TagResource
     * @throws NullValueException
     */
    public function show(int $id): TagResource
    {
        return $this->tagService->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\v1\TagRequest $request
     * @param int $id
     * @return \App\Http\Resources\v1\TagResource
     * @throws NullValueException
     */
    public function update(TagRequest $request, int $id): TagResource
    {
        return $this->tagService->update($request, $id);
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
        return $this->tagService->destroy($id);
    }
}
