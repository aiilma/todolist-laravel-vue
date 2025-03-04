<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TaskService
{
    public function getAllTasks($filters, Request $request): array
    {
        $userId = Auth::id();
        $totalTasksCount = Task::where('user_id', $userId)->count();
        $query = Task::where('user_id', $userId);

        foreach ($filters as $filter) {
            $query = $filter->apply($query, $request);
        }

        return [
            'total_tasks_count' => $totalTasksCount,
            'tasks' => $query->get(),
        ];
    }

    public function createTask(array $data): Task
    {
        $data['user_id'] = Auth::id();
        return Task::create($data);
    }

    public function updateTask(Task $task, array $data): Task
    {
        $task->update($data);
        return $task;
    }

    public function deleteTask(Task $task): void
    {
        $task->delete();
    }
}
