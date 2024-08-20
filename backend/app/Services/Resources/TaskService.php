<?php

namespace App\Services\Resources;

use App\Http\Exceptions\NullValueException;
use App\Http\Requests\v1\TaskRequest;
use App\Http\Resources\v1\TaskResource;
use App\Repositories\Resources\TaskRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    protected TaskRepository $taskRepository;
    protected OpenAiService $openAiService;
    protected TagService $tagService;
    protected CategoryService $categoryService;

    public function __construct(TaskRepository $taskRepository, OpenAiService $openAiService, TagService $tagService, CategoryService $categoryService)
    {
        $this->taskRepository = $taskRepository;
        $this->openAiService = $openAiService;
        $this->tagService = $tagService;
        $this->categoryService = $categoryService;
    }

    /**
     * Get all tasks for the authenticated user.
     *
     * @return AnonymousResourceCollection The collection of tasks as a JSON resource.
     * @throws NullValueException
     */
    public function index(): AnonymousResourceCollection
    {
        $user = Auth::user();
        $tasks = $this->taskRepository->getAllById($user->id);
        return \App\Http\Resources\v1\TaskResource::collection($tasks);
    }

    /**
     * Store a new task.
     *
     * @param \App\Http\Requests\v1\TaskRequest $request The task request instance.
     * @return \App\Http\Resources\v1\TaskResource The newly created task as a JSON resource.
     * @throws NullValueException
     */
    public function store(TaskRequest $request): \App\Http\Resources\v1\TaskResource
    {
        $data = $request->validated();
        $this->dataIsValid($data);
        $data['user_id'] = Auth::user()->id;
        $data['description'] = $this->getDescription($data);

        $task = $this->taskRepository->create($data);

        return new \App\Http\Resources\v1\TaskResource($task);
    }

    /**
     * Verifies if the provided category or tag Ids are valid
     *
     * @param array $data
     * @return void
     * @throws NullValueException
     */
    private function dataIsValid(array $data): void
    {
        foreach ($data['tag_id'] as $tag_id) {
            if (!$this->tagService->show($tag_id)) {
                return;
            }
        }

        foreach ($data['category_id'] as $category_id) {
            if (!$this->categoryService->show($category_id)) {
                return;
            }
        }
    }

    /**
     * Get a specific task by ID.
     *
     * @param int $id The task ID.
     * @return \App\Http\Resources\v1\TaskResource The task as a JSON resource.
     * @throws NullValueException
     */
    public function show(int $id): TaskResource
    {
        $user = Auth::user();
        $task = $this->taskRepository->getById($id, $user->id);
        return new \App\Http\Resources\v1\TaskResource($task);
    }

    /**
     * Get the description for the task.
     *
     * @param array $data The task data.
     * @return string The task description.
     */
    private function getDescription(array $data): string
    {
        if (!empty($data['description'])) {
            return $data['description'];
        }

        $prompt = 'Provide a description for the task based on the title. The language of the response should be based on the language of the title (probably portuguese). Your response will fill the description on the database, so be direct and do not use prefixes like: "Description", etc. Do not use line breaks';

        return $this->openAiService->chat($data, $prompt);
    }

    /**
     * Update a task.
     *
     * @param \App\Http\Requests\v1\TaskRequest $request The task request instance.
     * @param int $id The task ID.
     * @return \App\Http\Resources\v1\TaskResource The updated task as a JSON resource.
     * @throws NullValueException
     */
    public function update(TaskRequest $request, int $id): TaskResource
    {
        $data = $request->validated();
        $user = Auth::user();
        $task = $this->taskRepository->update($id, $data, $user->id);
        return new \App\Http\Resources\v1\TaskResource($task);
    }

    /**
     * Delete a task.
     *
     * @param int $id The task ID.
     * @return Response
     * @throws NullValueException
     */
    public function destroy(int $id): Response
    {
        $user = Auth::user();
        $this->taskRepository->delete($id, $user->id);
        return response()->noContent();
    }
}
