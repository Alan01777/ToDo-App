<?php

namespace App\Repositories;


use App\Http\Exceptions\NullValueException;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Response;
use App\Repositories\Contracts\ResourceRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryRepository implements ResourceRepositoryInterface
{
    private Category $category;

    /**
     * TaskRepository constructor.
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get all Categories owned by the current user.
     * @param int $userId The id of the current logged user.
     * @return AnonymousResourceCollection The paginated list of categories owned by the user.
     * @throws NullValueException Throws an exception if no category is found.
     */
    public function getAllById(int $userId): AnonymousResourceCollection
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
    public function create(array $data): Category
    {
        return $this->category->create($data);
    }

    /**
     * Update a Category by ID.
     *
     * @param int $id The id of the category which will be updated
     * @param array $data The data which will update the category
     * @param int $userId The id of the current user.
     * @return CategoryResource The resource which return the data of the category.
     * @throws NullValueException Throws an exception if no category is found.
     */
    public function update(int $id, array $data, int $userId): CategoryResource
    {
        $category = $this->getById($id, $userId);
        $category->update($data);
        return new CategoryResource($category);
    }

    /**
     * Find a Category by ID.
     *
     * @param int $id The id of the category to find.
     * @param int $userId The id of the current user.
     * @return Category The model instance which return the data of the category.
     * @throws NullValueException Throws an exception if no category is found.
     */
    public function getById(int $id, int $userId): Category
    {
        $category = $this->category->where('user_id', $userId)->where('id', $id)->first();
        if (!$category) {
            throw new NullValueException('No Category found with id ' . $id);
        }
        return $category;
    }

    /**
     * Delete a Category by ID.
     *
     * @param int $id The id of the category which will be updated
     * @param int $userId The id of the current user.
     * @return Response Return 204 (no content)
     * @throws NullValueException Throws an exception if no category is found.
     */
    public function delete(int $id, int $userId): Response
    {
        $category = $this->getById($id, $userId);
        $category->delete();
        return response()->noContent();
    }

    /**
     * Retrieve the titles of categories based on their IDs.
     *
     * @param int|array $ids The ID(s) of the categories to retrieve.
     * @return array The titles of the categories.
     */
    public function findCategoriesTitles(int|array $ids): array
    {
        $categories = [];
        $ids = is_array($ids) ? $ids : [$ids];

        foreach ($ids as $id) {
            $category = $this->category->where('id', $id)->first();
            if ($category) {
                $categories[] = $category->title;
            }
        }
        return $categories;
    }
}
