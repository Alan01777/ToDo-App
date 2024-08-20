<?php

namespace App\Repositories\Resources;

use App\Http\Exceptions\NullValueException;
use App\Http\Resources\v1\TaskResource;
use App\Models\Task;
use App\Repositories\Contracts\ResourceRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;


class TaskRepository implements ResourceRepositoryInterface
{
    private Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get all tasks.
     *
     * @return AnonymousResourceCollection The paginated list of users.
     * @throws NullValueException
     */
    public function getAllById(int $userId): AnonymousResourceCollection
    {
        $tasks = $this->task->with(['user', 'tags', 'categories'])->where('user_id', $userId)->paginate(10);
        if (!$tasks) {
            throw new NullValueException('No tasks found!');
        }
        return TaskResource::collection($tasks);
    }

    /**
     * Create a new task.
     *
     * @param array $data The data to create the task
     * @return Task The resource which will the return the updated task data
     * @throws NullValueException
     */
    public function create(array $data): Task
    {
        $task = $this->task->create($data);

        if (isset($data['tag_id'])) {
            $task->tags()->sync($data['tag_id']);
        }

        if (isset($data['category_id'])) {
            $task->categories()->sync($data['category_id']);
        }

        return $task;
    }

    /**
     * Update a task by ID.
     *
     * @param int $id The id of the Task to Update
     * @param array $data The data to update the task
     * @param int $userId The id of the current user
     * @return \App\Http\Resources\v1\TaskResource The resource which will the return the updated task data
     * @throws NullValueException Throws an exception if no Task is found
     */
    public function update(int $id, array $data, int $userId): TaskResource
    {
        $task = $this->getById($id, $userId);

        $task->update($data);

        if (isset($data['tag_id'])) {
            $task->tags()->sync($data['tag_id']);
        }

        if (isset($data['category_id'])) {
            $task->categories()->sync($data['category_id']);
        }

        return new \App\Http\Resources\v1\TaskResource($task);
    }

    /**
     * Find a task by ID.
     *
     * @param int $id The id of the Task to find
     * @param int $userId The id of the current user
     * @return Task The Task instance which will the return the updated task data
     * @throws NullValueException Throws an exception if no Task is found
     */
    public function getById(int $id, int $userId): Task
    {
        $task = $this->task->with(['tags', 'categories'])->where('id', $id)->where('user_id', $userId)->first();
        if (!$task) {
            throw new NullValueException('No task found with id' . $id);
        }
        return $task;
    }

    /**
     * Delete a task by ID.
     *
     * @param int $id The id of the task to delete
     * @param int $userId The id of the current user
     * @return Response Return 204 (no content)
     * @throws NullValueException Throws an exception if no Task is found
     */
    public function delete(int $id, int $userId): Response
    {
        $task = $this->getById($id, $userId);
        $task->delete();
        return response()->noContent();
    }
}
