<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository
{
    public function findByIdAndUserId(string $id, int $userId): ?Task
    {
        return Task::where('id', $id)->where('user_id', $userId)->first();
    }
}
