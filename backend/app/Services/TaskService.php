<?php

namespace App\Services;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Repositories\TaskRepository;
use App\Services\OpenAiService;
use Illuminate\Support\Facades\Auth;

/**
 * Class TaskService
 * 
 * This class is responsible for handling the business logic related to tasks.
 * It interacts with the TaskRepository to perform CRUD operations on tasks.
 * It also uses the OpenAiService to generate task descriptions based on titles.
 */
class TaskService
{
    protected $taskRepository;
    protected $openAiService;

    /**
     * TaskService constructor.
     *
     * @param TaskRepository $taskRepository The task repository instance.
     * @param OpenAiService $openAiService The OpenAI service instance.
     */
    public function __construct(TaskRepository $taskRepository, OpenAiService $openAiService)
    {
        $this->taskRepository = $taskRepository;
        $this->openAiService = $openAiService;
    }

    /**
     * Get all tasks for the authenticated user.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection The collection of tasks as a JSON resource.
     */
    public function index()
    {
        $user = Auth::user();
        $tasks = $this->taskRepository->findAllbyId($user->id);
        return TaskResource::collection($tasks);
    }

    /**
     * Store a new task.
     *
     * @param TaskRequest $request The task request instance.
     * @return TaskResource The newly created task as a JSON resource.
     */
    public function store(TaskRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = Auth::user()->id;
        $data['description'] = $this->getDescription($data);

        $task = $this->taskRepository->create($data);

        return new TaskResource($task);
    }

    /**
     * Get the description for the task.
     *
     * @param array $data The task data.
     * @return string The task description.
     */
    private function getDescription($data)
    {
        if (isset($data['description']) && !empty($data['description'])) {
            return $data['description'];
        }

        $prompt = 'Provide a description for the task based on the title. The language of the response should be based on the language of the title (probably portuguese). Your response will fill the description on the database, so be direct and do not use prefixes like: "Description", etc. Do not use line breaks';

        return $this->openAiService->chat($data, $prompt);
    }

    /**
     * Get a specific task by ID.
     *
     * @param int $id The task ID.
     * @return TaskResource The task as a JSON resource.
     */
    public function show(int $id)
    {
        $user = Auth::user();
        $task = $this->taskRepository->find($id, $user->id);
        return new TaskResource($task);
    }

    /**
     * Update a task.
     *
     * @param TaskRequest $request The task request instance.
     * @param int $id The task ID.
     * @return TaskResource The updated task as a JSON resource.
     */
    public function update(TaskRequest $request, int $id)
    {
        $data = $request->validated();
        $user = Auth::user();
        $task = $this->taskRepository->update($id, $data, $user->id);
        return new TaskResource($task);
    }

    /**
     * Delete a task.
     *
     * @param int $id The task ID.
     * @return \Illuminate\Http\JsonResponse The JSON response.
     */
    public function destroy(int $id)
    {
        $user = Auth::user();
        $this->taskRepository->delete($id, $user->id);
        return response()->json(null, 204);
    }
}