<?php

namespace App\Http\Services;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Http\Repositories\TaskRepository;
use App\Http\Services\OpenAiService;
use OpenAI;

/**
 * Class TaskService
 * @package App\Http\Services
 */
class TaskService
{
    /**
     * @var TaskRepository
     */
    protected $taskRepository;
    protected $openAiService;

    /**
     * TaskService constructor.
     * @param TaskRepository $taskRepository
     * @param OpenAiService $openAiService
     */
    public function __construct(TaskRepository $taskRepository, OpenAiService $openAiService)
    {
        $this->taskRepository = $taskRepository;
        $this->openAiService = $openAiService;
    }

    /**
     * Get all Tasks.
     *
     * @return TaskResource
     */
    public function index()
    {
        $Tasks = $this->taskRepository->findall();
        return TaskResource::collection($Tasks);
    }

    /**
     * Store a new Task.
     *
     * @param TaskRequest $request
     * @return TaskResource
     */
    public function store(TaskRequest $request)
    {
        $data = $request->validated();

        $data['description'] = $this->getDescription($data);

        $task = $this->taskRepository->create($data);

        return new TaskResource($task);
    }

    /**
     * Get the description for the task based on the title.
     *
     * This method retrieves the description for a task based on its title. If the task already has a description provided in the $data array, it will be returned directly. Otherwise, it will use the OpenAI service to generate a description based on the title.
     *
     * @param array $data The data array containing the task title and optional description.
     * @return string The description for the task.
     */
    private function getDescription($data)
    {
        if (isset($data['description']) && !empty($data['description'])) {
            return $data['description'];
        }

        $prompt = 'Provide a description for the task based on the title. The language of the response should be based on the language of the title (probably portuguese). Your response will fill the description on the database, so be direct and do not use prefixes like: "Description", etc. Do not use line breaks';

        return $this->openAiService->chat($data['title'], $prompt);
    }

    /**
     * Get a specific Task by ID.
     *
     * @param int $id
     * @return TaskResource
     */
    public function show(int $id)
    {
        $Task = $this->taskRepository->find($id);
        return new TaskResource($Task);
    }

    /**
     * Update a Task.
     *
     * @param TaskRequest $request
     * @param int $id
     * @return TaskResource
     */
    public function update(TaskRequest $request, int $id)
    {
        $data = $request->validated();
        $Task = $this->taskRepository->update($id, $data);
        return new TaskResource($Task);
    }

    /**
     * Delete a Task.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $this->taskRepository->delete($id);
        return response()->json(null, 204);
    }
}
