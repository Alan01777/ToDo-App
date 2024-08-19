<?php

namespace App\Services;

use App\Http\Exceptions\NullValueException;
use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use App\Repositories\TagRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TagService
{
    protected TagRepository $tagRepository;


    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * Get all Tags.
     *
     * @return AnonymousResourceCollection
     * @throws NullValueException
     */
    public function index(): AnonymousResourceCollection
    {
        $user = Auth::user();
        $tags = $this->tagRepository->getAllById($user->id);

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
        $data = array_merge($validatedData, ['user_id' => Auth::user()->id]);

        $tag = $this->tagRepository->create($data);

        return new TagResource($tag);
    }

    /**
     * Get a specific Tag by ID.
     *
     * @param int $id
     * @return TagResource
     * @throws NullValueException
     */
    public function show(int $id): TagResource
    {
        $user = Auth::user();
        $tag = $this->tagRepository->getById($id, $user->id);


        return new TagResource($tag);
    }

    /**
     * Update a Tag.
     *
     * @param TagRequest $request
     * @param int $id
     * @return TagResource
     * @throws NullValueException
     */
    public function update(TagRequest $request, int $id): TagResource
    {
        $user = Auth::user();
        $validatedData = $request->validated();
        $data = array_merge($validatedData, ['user_id' => $user->id]);

        $tag = $this->tagRepository->update($id, $data, $user->id);

        return new TagResource($tag);
    }

    /**
     * Delete a Tag.
     *
     * @param int $id
     * @return Response
     * @throws NullValueException
     */
    public function destroy(int $id): Response
    {
        $user = Auth::user();
        $this->tagRepository->delete($id, $user->id);

        return response()->noContent();
    }
}
