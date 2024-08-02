<?php

namespace App\Http\Repositories;

use App\Http\Exceptions\NullValueException;
use App\Http\Repositories\Contracts\RepositoryInterface;
use App\Http\Resources\TaskResource;
use App\Http\Services\OpenAiService;
use App\Models\Task;

/**
 * Class TaskRepository
 * @package App\Http\Respositories
 */
class TaskRepository implements RepositoryInterface
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
    public function findall()
    {
        $tasks = $this->task->with('user')->paginate(25);
        if(!$tasks){
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
        return $this->task->create($data);
    }

    /**
     * Find a task by ID.
     *
     * @param int $id
     * @return TaskResource
     * @throws NullValueException
     */
    public function find($id)
    {
        $task = $this->task->find($id);
        if(!$task){
            throw new NullValueException('No task found with id' . $id);
        }
        return $task;
    }

    /**
     * Update a task by ID.
     *
     * @param array $data
     * @param int $id
     * @return TaskResource
     * @throws NullValueException
     */
    public function update($id, $data)
    {
        $task = $this->find($id);
        if(!$task){
            throw new NullValueException('No task found with id: ' . $id);
        }
        $task->update($data);
        return new TaskResource($task);
    }

    /**
     * Delete a task by ID.
     *
     * @param int $id
     * @throws NullValueException
     */
    public function delete($id)
    {
        $task = $this->find($id);
        if(!$task){
            throw new NullValueException('No task found with id' . $id);
        }
        $task->delete($id);
    }
}