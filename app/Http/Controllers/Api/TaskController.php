<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends BaseController
{
    public function __construct(
        protected TaskService $taskService
        )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tasks = $this->taskService->getAll();
        return new TaskCollection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $task = $this->taskService->create($request->validated());
        return $this->sendSuccess(new TaskResource($task), 'Task created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $task = $this->taskService->getById($id);
        return $this->sendSuccess(new TaskResource($task), 'Task retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, string $id)
    {
        $task = $this->taskService->getById($id);
        $task = $this->taskService->update($task, $request->validated());

        return $this->sendSuccess(new TaskResource($task), 'Task updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $task = $this->taskService->getById($id);
        $this->taskService->delete($task);

        return $this->sendSuccess(null, 'Task deleted successfully');
    }
}