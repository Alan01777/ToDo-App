<?php

namespace App\Repositories;

use App\Http\Exceptions\NullValueException;
use App\Repositories\Contracts\ResourceRepositoryInterface;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class TagRepository
 * @package App\Http\Respositories
 */
class TagRepository implements ResourceRepositoryInterface
{
    private Tag $tag;

    /**
     * TaskRepository constructor.
     * @param Tag $tag
     */
    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * Get all tags.
     *
     * @param int $userId The id of the current user.
     * @return AnonymousResourceCollection The paginated list of Tags
     * @throws NullValueException throws an exception if no Tag is found
     */
    public function findAllById(int $userId): AnonymousResourceCollection
    {
        $tags = $this->tag->with('tasks')->where('user_id', $userId)->paginate(25);
        if (!$tags) {
            throw new NullValueException('No tags found!');
        }
        return TagResource::collection($tags);
    }

    /**
     * Create a new Tag.
     *
     * @param array $data The data to create a new Tag
     * @return Tag The tag which will return the Tag data
     */
    public function create(array $data): Tag
    {
        return $this->tag->create($data);
    }

    /**
     * Find a tag by ID.
     *
     * @param int $id The id of the Tag to find
     * @param int $userId The id of the current user
     * @return TagResource The resource which will return the Tag data
     * @throws NullValueException throws an exception if no Tag is found
     */
    public function find(int $id, int $userId): TagResource
    {
        $tag = $this->tag->where('id', $id)->where('user_id', $userId)->first();
        if (!$tag) {
            throw new NullValueException('No tag found with id ' . $id);
        }
        return new TagResource($tag);
    }

    /**
     * Update a tag by ID.
     *
     * @param array $data The data to create a new Tag
     * @param int $id The id of the Tag which will be updated
     * @return TagResource The resource which will return the Tag data
     * @throws NullValueException throws an exception if no Tag is found
     */
    public function update(int $id, array $data, int $userId): TagResource
    {
        $tag = $this->find($id, $userId);
        $tag->update($data);
        return new TagResource($tag);
    }

    /**
     * Delete a tag by ID.
     *
     * @param int $id The id of the Tag to delete
     * @param int $userId The id of the current user
     * @return Response Return a 204 code (no content)
     * @throws NullValueException
     */
    public function delete(int $id, int $userId): Response
    {
        $tag = $this->find($id, $userId);
        $tag->delete($id);
        return response()->noContent();
    }

    /**
     * Find tag titles by their IDs.
     *
     * @param int|array $ids The IDs of the tags to find.
     * @return array The titles of the found tags.
     */
    public function findTagTitles(int|array $ids): array
    {
        $tags = [];
        $ids = is_array($ids) ? $ids : [$ids];

        foreach ($ids as $id) {
            $tag = $this->tag->where('id', $id)->first();
            if ($tag) {
                $tags[] = $tag->title;
            }
        }
        return $tags;
    }
}
