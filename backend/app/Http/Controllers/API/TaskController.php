<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param TaskService $taskService
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(TaskService $taskService)
    {
        return $taskService->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TaskService $taskService
     * @param TaskRequest $request
     * @return \App\Http\Resources\TaskResource
     */
    public function store(TaskService $taskService, TaskRequest $request)
    {
        return $taskService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param TaskService $taskService
     * @param int $id
     * @return \App\Http\Resources\TaskResource
     */
    public function show(TaskService $taskService, int $id)
    {
        return $taskService->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TaskRequest $request
     * @param TaskService $taskService
     * @param int $id
     * @return \App\Http\Resources\TaskResource
     */
    public function update(TaskRequest $request, TaskService $taskService, int $id)
    {
        return $taskService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TaskService $taskService
     * @param int $id
     * @return null
     */
    public function destroy(TaskService $taskService, int $id)
    {
        return $taskService->destroy($id);
    }
}
