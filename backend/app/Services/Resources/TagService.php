<?php

namespace App\Services\Resources;

use App\Http\Exceptions\NullValueException;
use App\Http\Requests\v1\TagRequest;
use App\Http\Resources\v1\TagResource;
use App\Repositories\Resources\TagRepository;
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

        return \App\Http\Resources\v1\TagResource::collection($tags);
    }

    /**
     * Store a new Tag.
     *
     * @param \App\Http\Requests\v1\TagRequest $request
     * @return TagResource
     */
    public function store(TagRequest $request): \App\Http\Resources\v1\TagResource
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
    public function show(int $id): \App\Http\Resources\v1\TagResource
    {
        $user = Auth::user();
        $tag = $this->tagRepository->getById($id, $user->id);


        return new \App\Http\Resources\v1\TagResource($tag);
    }

    /**
     * Update a Tag.
     *
     * @param \App\Http\Requests\v1\TagRequest $request
     * @param int $id
     * @return \App\Http\Resources\v1\TagResource
     * @throws NullValueException
     */
    public function update(TagRequest $request, int $id): TagResource
    {
        $user = Auth::user();
        $validatedData = $request->validated();
        $data = array_merge($validatedData, ['user_id' => $user->id]);

        $tag = $this->tagRepository->update($id, $data, $user->id);

        return new \App\Http\Resources\v1\TagResource($tag);
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
