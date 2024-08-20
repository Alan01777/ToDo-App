<?php

namespace App\Services\Resources;

use App\Http\Exceptions\NullValueException;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Repositories\Resources\CategoryRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CategoryService
{
    protected CategoryRepository $categoryRepository;
    protected OpenAiService $openAiService;

    public function __construct(CategoryRepository $categoryRepository, OpenAiService $openAiService)
    {
        $this->categoryRepository = $categoryRepository;
        $this->openAiService = $openAiService;
    }

    /**
     * Get all Categories.
     *
     * @return AnonymousResourceCollection
     * @throws NullValueException
     */
    public function index(): AnonymousResourceCollection
    {
        $user = Auth::user();
        $categories = $this->categoryRepository->getAllById($user->id);

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
        $data = array_merge($validatedData, ['user_id' => Auth::user()->id]);
        $data['description'] = $this->getDescription($data);

        $category = $this->categoryRepository->create($data);

        return new CategoryResource($category);
    }

    /**
     * Get a specific Category by ID.
     *
     * @param int $id
     * @return CategoryResource
     * @throws NullValueException
     */
    public function show(int $id): CategoryResource
    {
        $user = Auth::user();
        $category = $this->categoryRepository->getById($id, $user->id);

        return new CategoryResource($category);
    }

    /**
     * Update a Category.
     *
     * @param CategoryRequest $request
     * @param int $id
     * @return CategoryResource
     * @throws NullValueException
     */
    public function update(CategoryRequest $request, int $id): CategoryResource
    {
        $user = Auth::user();
        $validatedData = $request->validated();
        $data = array_merge($validatedData, ['user_id' => $user->id]);

        $category = $this->categoryRepository->update($id, $data, $user->id);

        return new CategoryResource($category);
    }

    /**
     * Delete a Category.
     *
     * @param int $id
     * @return Response
     * @throws NullValueException
     */
    public function destroy(int $id): Response
    {
        $user = Auth::user();
        $this->categoryRepository->delete($id, $user->id);

        return response()->noContent();
    }

    /**
     * Retrieves the description for a task category.
     *
     * @param array $data The data array containing the 'title' and 'description' keys.
     * @return string The description for the task category.
     */
    private function getDescription(array $data): string
    {
        if (!empty($data['description'])) {
            return $data['description'];
        }

        $prompt = 'Provide a description for the a task category based on the title. The language of the response should be based on the language of the title (probably portuguese). Your response will fill the description on the database, so be direct and do not use prefixes like: "Description", etc.';

        return $this->openAiService->chat(['title' => $data['title']], $prompt);
    }
}
