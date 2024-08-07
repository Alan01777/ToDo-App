<?php

namespace App\Http\Services;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Http\Repositories\TaskRepository;
use App\Http\Services\OpenAiService;

/**
 * Class TaskService
 * @package App\Http\Services
 */
class TaskService
{
    protected $taskRepository;
    protected $openAiService;

    public function __construct(TaskRepository $taskRepository, OpenAiService $openAiService)
    {
        $this->taskRepository = $taskRepository;
        $this->openAiService = $openAiService;
    }

    public function index()
    {
        $user = auth()->user();
        $tasks = $this->taskRepository->findAllbyId($user->id);
        return TaskResource::collection($tasks);
    }

    public function store(TaskRequest $request)
    {
        $data = $request->validated();
        $data['description'] = $this->getDescription($data);
        $data['user_id'] = auth()->user()->id;

        $task = $this->taskRepository->create($data);

        return new TaskResource($task);
    }

    private function getDescription($data)
    {
        if (isset($data['description']) && !empty($data['description'])) {
            return $data['description'];
        }

        $prompt = 'Provide a description for the task based on the title. The language of the response should be based on the language of the title (probably portuguese). Your response will fill the description on the database, so be direct and do not use prefixes like: "Description", etc. Do not use line breaks';

        return $this->openAiService->chat($data['title'], $prompt);
    }

    public function show(int $id)
    {
        $user = auth()->user();
        $task = $this->taskRepository->find($id, $user->id);
        return new TaskResource($task);
    }

    public function update(TaskRequest $request, int $id)
    {
        $data = $request->validated();
        $user = auth()->user();
        $task = $this->taskRepository->update($id, $data, $user->id);
        return new TaskResource($task);
    }

    public function destroy(int $id)
    {
        $user = auth()->user();
        $this->taskRepository->delete($id, $user->id);
        return response()->json(null, 204);
    }
}