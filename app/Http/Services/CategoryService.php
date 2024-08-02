<?php

namespace App\Http\Services;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Repositories\CategoryRepository;
use App\Http\Services\OpenAiService;

/**
 * Class CategoryService
 * @package App\Http\Services
 */
class CategoryService
{
    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;
    protected $openAiService;

    /**
     * CategoryService constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository, OpenAiService $openAiService)
    {
        $this->categoryRepository = $categoryRepository;
        $this->openAiService = $openAiService;
    }

    /**
     * Get all Categories.
     *
     * @return CategoryResource
     */
    public function index()
    {
        $categories = $this->categoryRepository->findAll();
        return CategoryResource::collection($categories);
    }

    /**
     * Store a new Category.
     *
     * @param CategoryRequest $request
     * @return CategoryResource
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->validated();

        $data['description'] = $this->getDescription($data);

        $category = $this->categoryRepository->create($data);
        return new CategoryResource($category);
    }

    /**
     * Retrieves the description for a task category.
     *
     * If the 'description' key is set and not empty in the given data array,
     * it returns the value of the 'description' key.
     * Otherwise, it prompts the user to provide a description based on the title.
     * The language of the response should be based on the language of the title (probably Portuguese).
     * The response will be used to fill the description field in the database.
     *
     * @param array $data The data array containing the 'title' and 'description' keys.
     * @return string The description for the task category.
     */
    private function getDescription($data)
    {
        if (isset($data['description']) && !empty($data['description'])) {
            return $data['description'];
        }

        $prompt = 'Provide a description for the a task category based on the title. The language of the response should be based on the language of the title (probably portuguese). Your response will fill the description on the database, so be direct and do not use prefixes like: "Description", etc.';

        return $this->openAiService->chat($data['title'], $prompt);
    }
    /**
     * Get a specific Category by ID.
     *
     * @param int $id
     * @return CategoryResource
     */
    public function show(int $id)
    {
        $category = $this->categoryRepository->find($id);
        return new CategoryResource($category);
    }

    /**
     * Update a Category.
     *
     * @param CategoryRequest $request
     * @param int $id
     * @return CategoryResource
     */
    public function update(CategoryRequest $request, int $id)
    {
        $data = $request->validated();
        $category = $this->categoryRepository->update($id, $data);
        return new CategoryResource($category);
    }

    /**
     * Delete a Category.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $this->categoryRepository->delete($id);
        return response()->json(null, 204);
    }
}
