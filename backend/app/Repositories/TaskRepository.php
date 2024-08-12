<?php

namespace App\Repositories;

use App\Http\Exceptions\NullValueException;
use App\Repositories\Contracts\ResourceRepositoryInterface;
use App\Http\Resources\TaskResource;
use App\Models\Task;

/**
 * Class TaskRepository
 * @package App\Http\Respositories
 */
class TaskRepository implements ResourceRepositoryInterface
{
    private $task;

    /**
     * TaskRepository constructor.
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get all tasks.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator The paginated list of users.
     * @throws NullValueException
     */
    public function findAllbyId($userId)
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
     * @param array $data
     * @return Task
     */
    public function create($data)
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
     * Find a task by ID.
     *
     * @param int $id
     * @param int $userId
     * @return TaskResource
     * @throws NullValueException
     */
    public function find($id, $userId)
    {
        $task = $this->task->with(['tags', 'categories'])->where('id', $id)->where('user_id', $userId)->first();
        if (!$task) {
            throw new NullValueException('No task found with id' . $id);
        }
        return $task;
    }

    /**
     * Update a task by ID.
     *
     * @param array $data
     * @param int $id
     * @param int $userId
     * @return TaskResource
     * @throws NullValueException
     */
    public function update($id, $data, $userId)
    {
        $task = $this->find($id, $userId);
        if (!$task) {
            throw new NullValueException('No task found with id: ' . $id);
        }

        $task->update($data);

        if (isset($data['tag_id'])) {
            $task->tags()->sync($data['tag_id']);
        }

        if (isset($data['category_id'])) {
            $task->categories()->sync($data['category_id']);
        }

        return new TaskResource($task);
    }

    /**
     * Delete a task by ID.
     *
     * @param int $id
     * @param int $userId
     * @throws NullValueException
     */
    public function delete($id, $userId)
    {
        $task = $this->find($id, $userId);
        if (!$task) {
            throw new NullValueException('No task found with id' . $id);
        }
        $task->delete($id);
    }
}