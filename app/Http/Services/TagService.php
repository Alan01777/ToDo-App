<?php

namespace App\Http\Services;

use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use App\Http\Repositories\TagRepository;

/**
 * Class TaskService
 * @package App\Http\Services
 */
class TagService
{
    /**
     * @var TagRepository
     */
    protected $tagRepository;

    /**
     * TaskService constructor.
     * @param TagRepository $tagRepository
     */
    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * Get all Tags.
     *
     * @return TagResource
     */
    public function index()
    {
        $Tags = $this->tagRepository->findall();
        return TagResource::collection($Tags);
    }

    /**
     * Store a new Tag.
     *
     * @param TagRequest $request
     * @return TagResource
     */
    public function store(TagRequest $request)
    {
        $data = $request->validated();
        $tag = $this->tagRepository->create($data);
        return new TagResource($tag);
    }

    /**
     * Get a specific Tag by ID.
     *
     * @param int $id
     * @return TagResource
     */
    public function show(int $id)
    {
        $tag = $this->tagRepository->find($id);
        return new TagResource($tag);
    }

    /**
     * Update a Tag.
     *
     * @param TagRequest $request
     * @param int $id
     * @return TagResource
     */
    public function update(TagRequest $request, int $id)
    {
        $data = $request->validated();
        $tag = $this->tagRepository->update($id, $data);
        return new TagResource($tag);
    }

    /**
     * Delete a Tag.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $this->tagRepository->delete($id);
        return response()->json(null, 204);
    }
}