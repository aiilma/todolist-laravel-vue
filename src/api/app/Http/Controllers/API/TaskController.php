<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends BaseController
{
    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $filters = [
            new \App\Filters\StatusFilter(),
            new \App\Filters\DeadlineFilter(),
        ];

        $tasksData = $this->taskService->getAllTasks($filters, $request);

        return $this->sendResponse($tasksData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = $this->taskService->createTask($request->validated());

        return $this->sendResponse($task, 'Task created successfully.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);
        if (!$task) {
            return $this->sendError('Task not found.', 404);
        }

        $task->makeHidden('id');
        return $this->sendResponse($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, string $id): JsonResponse
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);
        if (!$task) {
            return $this->sendError('Task not found.', 404);
        }

        $task = $this->taskService->updateTask($task, $request->validated());

        return $this->sendResponse($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);
        if (!$task) {
            return $this->sendError('Task not found.', 404);
        }

        $this->taskService->deleteTask($task);

        return $this->sendResponse(null, 'Task deleted successfully.', 204);
    }
}
