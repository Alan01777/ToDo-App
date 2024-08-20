<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Exceptions\NullValueException;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\Resources\TaskService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     * @throws NullValueException
     */
    public function index(): AnonymousResourceCollection
    {
        return $this->taskService->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TaskRequest $request
     * @return TaskResource
     * @throws NullValueException
     */
    public function store(TaskRequest $request): TaskResource
    {
        return $this->taskService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return TaskResource
     * @throws NullValueException
     */
    public function show(int $id): TaskResource
    {
        return $this->taskService->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TaskRequest $request
     * @param int $id
     * @return TaskResource
     * @throws NullValueException
     */
    public function update(TaskRequest $request, int $id): TaskResource
    {
        return $this->taskService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     * @throws NullValueException
     */
    public function destroy(int $id): Response
    {
        $this->taskService->destroy($id);
        return response()->noContent();
    }
}
