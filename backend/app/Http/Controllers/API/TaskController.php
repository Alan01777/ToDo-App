<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskService;

    /**
     * TaskController constructor.
     *
     * @param TaskService $taskService
     */
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param TaskService $taskService
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return $this->taskService->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TaskRequest $request
     * @return \App\Http\Resources\TaskResource
     */
    public function store(TaskRequest $request)
    {
        return $this->taskService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \App\Http\Resources\TaskResource
     */
    public function show(int $id)
    {
        return $this->taskService->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TaskRequest $request
     * @param int $id
     * @return \App\Http\Resources\TaskResource
     */
    public function update(TaskRequest $request, int $id)
    {
        return $this->taskService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return null
     */
    public function destroy(int $id)
    {
        return $this->taskService->destroy($id);
    }
}
