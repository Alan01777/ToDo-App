<?php

namespace App\Http\Repositories;

use App\Http\Exceptions\NullValueException;
use App\Http\Repositories\Contracts\RepositoryInterface;
use App\Http\Resources\TagResource;
use App\Models\Tag;

/**
 * Class TagRepository
 * @package App\Http\Respositories
 */
class TagRepository implements RepositoryInterface
{
    private $tag;

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
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator The paginated list of users.
     * @throws NullValueException
     */
    public function findAllbyId($userId)
    {
        $tags = $this->tag->with('tasks')->where('user_id', $userId)->paginate(25);
        if (!$tags) {
            throw new NullValueException('No tags found!');
        }
        return TagResource::collection($tags);
    }

    /**
     * Create a new task.
     *
     * @param array $data
     * @return Tag
     */
    public function create($data)
    {
        return $this->tag->create($data);
    }

    /**
     * Find a tag by ID.
     *
     * @param int $id
     * @return TagResource
     * @throws NullValueException
     */
    public function find($id, $userId)
    {
        $tag = $this->tag->where('id', $id)->where('user_id', $userId)->first();
        if (!$tag) {
            throw new NullValueException('No tag found with id' . $id);
        }
        return $tag;
    }

    /**
     * Update a tag by ID.
     *
     * @param array $data
     * @param int $id
     * @return TagResource
     * @throws NullValueException
     */
    public function update($id, $data, $userId)
    {
        $tag = $this->find($id, $userId);
        if (!$tag) {
            throw new NullValueException('No tag found with id: ' . $id);
        }
        $tag->update($data);
        return new TagResource($tag);
    }

    /**
     * Delete a tag by ID.
     *
     * @param int $id
     * @throws NullValueException
     */
    public function delete($id, $userId)
    {
        $tag = $this->find($id, $userId);
        if (!$tag) {
            throw new NullValueException('No tag found with id' . $id);
        }
        $tag->delete($id);
    }

    /**
     * Find tag titles by their IDs.
     *
     * @param mixed $ids The IDs of the tags to find.
     * @return array The titles of the found tags.
     */
    public function findTagTitles($ids)
    {
        $tags = [];
        $ids = is_array($ids) ? $ids : [$ids]; // Ensure $ids is an array

        foreach ($ids as $id) {
            $tag = $this->tag->where('id', $id)->first();
            if ($tag) {
                $tags[] = $tag->title;
            }
        }
        return $tags;
    }
}
