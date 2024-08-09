<?php

namespace App\Http\Services;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Repositories\CategoryRepository;
use App\Http\Services\OpenAiService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;

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

    /**
     * @var OpenAiService
     */
    protected $openAiService;

    /**
     * CategoryService constructor.
     *
     * @param CategoryRepository $categoryRepository
     * @param OpenAiService $openAiService
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
    public function index(): AnonymousResourceCollection
    {
        $user = auth()->user();
        $categories = $this->categoryRepository->findAllbyId($user->id);

        return CategoryResource::collection($categories);
    }

    /**
     * Store a new Category.
     *
     * @param CategoryRequest $request
     * @return CategoryResource
     */
    public function store(CategoryRequest $request): CategoryResource
    {
        $validatedData = $request->validated();
        $data = array_merge($validatedData, ['user_id' => auth()->user()->id]);
        $data['description'] = $this->getDescription($data);

        $category = $this->categoryRepository->create($data);

        return new CategoryResource($category);
    }

    /**
     * Get a specific Category by ID.
     *
     * @param int $id
     * @return CategoryResource
     */
    public function show(int $id): CategoryResource
    {
        $user = auth()->user();
        $category = $this->categoryRepository->find($id, $user->id);

        return new CategoryResource($category);
    }

    /**
     * Update a Category.
     *
     * @param CategoryRequest $request
     * @param int $id
     * @return CategoryResource
     */
    public function update(CategoryRequest $request, int $id): CategoryResource
    {
        $user = auth()->user();
        $validatedData = $request->validated();
        $data = array_merge($validatedData, ['user_id' => $user->id]);

        $category = $this->categoryRepository->update($id, $data, $user->id);

        return new CategoryResource($category);
    }

    /**
     * Delete a Category.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $user = auth()->user();
        $this->categoryRepository->delete($id, $user->id);

        return response()->json(null, 204);
    }

    /**
     * Retrieves the description for a task category.
     *
     * @param array $data The data array containing the 'title' and 'description' keys.
     * @return string The description for the task category.
     */
    private function getDescription(array $data): string
    {
        if (isset($data['description']) && !empty($data['description'])) {
            return $data['description'];
        }

        $prompt = 'Provide a description for the a task category based on the title. The language of the response should be based on the language of the title (probably portuguese). Your response will fill the description on the database, so be direct and do not use prefixes like: "Description", etc.';

        return $this->openAiService->chat(['title' => $data['title']], $prompt);
    }
}
