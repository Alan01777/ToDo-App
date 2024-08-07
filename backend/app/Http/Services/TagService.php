<?php

namespace App\Http\Services;

use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use App\Http\Repositories\TagRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class TagService
 * @package App\Http\Services
 */
class TagService
{
    /**
     * @var TagRepository
     */
    protected $tagRepository;

    /**
     * TagService constructor.
     *
     * @param TagRepository $tagRepository
     */
    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * Get all Tags.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $user = auth()->user();
        $tags = $this->tagRepository->findAllbyId($user->id);

        return TagResource::collection($tags);
    }

    /**
     * Store a new Tag.
     *
     * @param TagRequest $request
     * @return TagResource
     */
    public function store(TagRequest $request): TagResource
    {
        $validatedData = $request->validated();
        $data = array_merge($validatedData, ['user_id' => auth()->user()->id]);

        $tag = $this->tagRepository->create($data);

        return new TagResource($tag);
    }

    /**
     * Get a specific Tag by ID.
     *
     * @param int $id
     * @return TagResource
     */
    public function show(int $id): TagResource
    {
        $user = auth()->user();
        $tag = $this->tagRepository->find($id, $user->id);

        return new TagResource($tag);
    }

    /**
     * Update a Tag.
     *
     * @param TagRequest $request
     * @param int $id
     * @return TagResource
     */
    public function update(TagRequest $request, int $id): TagResource
    {
        $user = auth()->user();
        $validatedData = $request->validated();
        $data = array_merge($validatedData, ['user_id' => $user->id]);

        $tag = $this->tagRepository->update($id, $data, $user->id);

        return new TagResource($tag);
    }

    /**
     * Delete a Tag.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $user = auth()->user();
        $this->tagRepository->delete($id, $user->id);

        return response()->json(null, 204);
    }
}