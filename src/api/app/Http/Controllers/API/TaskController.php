<?php

namespace App\Http\Controllers\API;

use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $userId = Auth::id();
        $totalTasksCount = Task::where('user_id', $userId)->count();
        $query = Task::where('user_id', $userId);

        foreach ([
            new \App\Filters\StatusFilter(),
            new \App\Filters\DeadlineFilter(),
                     ] as $filter) {
            $query = $filter->apply($query, $request);
        }

        $tasks = $query->get();

        return $this->sendResponse([
            'total_tasks_count' => $totalTasksCount,
            'tasks' => $tasks,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $taskStatuses = implode(',', array_column(TaskStatus::cases(), 'value'));
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:' . $taskStatuses,
            'deadline' => 'nullable|date',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'deadline' => $request->deadline,
            'user_id' => Auth::id(),
        ]);

        return $this->sendResponse($task, 'Task created successfully.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);
        $task->makeHidden('id');
        return $this->sendResponse($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:new,in_progress,completed',
            'deadline' => 'nullable|date',
        ]);

        $task->update($request->all());

        return $this->sendResponse($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);
        $task->delete();

        return $this->sendResponse(null, 'Task deleted successfully.', 204);
    }
}
