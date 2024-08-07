<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(TaskService $taskService)
    {
        return $taskService->index();
    }

    public function store(TaskService $taskService, TaskRequest $request)
    {
        return $taskService->store($request);
    }

    public function show(TaskService $taskService, int $id)
    {
        return $taskService->show($id);
    }

    public function update(TaskRequest $request, TaskService $taskService, int $id)
    {
        return $taskService->update($request, $id);
    }

    public function destroy(TaskService $taskService, int $id)
    {
        return $taskService->destroy($id);
    }
}
