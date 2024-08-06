<?php

namespace App\Http\Repositories;


use App\Http\Exceptions\NullValueException;
use App\Http\Repositories\Contracts\RepositoryInterface;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

/**
 * Class CategoryRepository
 * @package App\Http\Respositories
 */
class CategoryRepository implements RepositoryInterface
{
    private $category;

    /**
     * TaskRepository constructor.
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get all Categories.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator The paginated list of users.
     * @throws NullValueException
     */
    public function findAllbyId($userId)
    {
        $categories = $this->category->with('tasks')->where('user_id', $userId)->paginate(25);
        if (!$categories) {
            throw new NullValueException('No Categories found!');
        }
        return CategoryResource::collection($categories);
    }

    /**
     * Create a new category.
     *
     * @param array $data
     * @return Category
     */
    public function create($data)
    {
        return $this->category->create($data);
    }

    /**
     * Find a Category by ID.
     *
     * @param int $id
     * @return CategoryResource
     * @throws NullValueException
     */
    public function find($id, $userId)
    {
        $category = $this->category->where('user_id', $userId)->where('id', $id)->first();
        if (!$category) {
            throw new NullValueException('No Category found with id' . $id);
        }
        return $category;
    }

    /**
     * Update a Category by ID.
     *
     * @param array $data
     * @param int $id
     * @return CategoryResource
     * @throws NullValueException
     */
    public function update($id, $data, $userId)
    {
        $category = $this->find($id, $userId); // Call the find method using $this
        if (!$category) {
            throw new NullValueException('No Category found with id: ' . $id);
        }
        $category->update($data);
        return new CategoryResource($category);
    }

    /**
     * Delete a Category by ID.
     *
     * @param int $id
     * @throws NullValueException
     */
    public function delete($id, $userId)
    {
        $category = $this->find($id, $userId);
        if (!$category) {
            throw new NullValueException('No Category found with id' . $id);
        }
        $category->delete($id);
    }
}
