<?php

namespace App\Services;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskService
{
    /**
     * Ambil semua task (paginate 10 per page).
     */
    public function getAll(): LengthAwarePaginator
    {
        return Task::latest()->paginate(10);
    }

    /**
     * Ambil task by id (throws ModelNotFoundException jika tidak ada).
     */
    public function getById(string $id): Task
    {
        return Task::findOrFail($id);
    }

    /**
     * Buat task baru.
     */
    public function create(array $data): Task
    {
        return Task::create($data);
    }

    /**
     * Update task dan tangani logika completed_at.
     */
    public function update(Task $task, array $data): Task
    {
        // Logika auto completed_at juga dihandle di UpdateTaskRequest (passedValidation)
        // Tapi untuk robustness, kita handle juga di level service:
        if (isset($data['status'])) {
            if ($data['status'] === TaskStatus::COMPLETED->value && $task->status !== TaskStatus::COMPLETED) {
                $data['completed_at'] = now();
            }
            elseif ($data['status'] !== TaskStatus::COMPLETED->value && $task->status === TaskStatus::COMPLETED) {
                $data['completed_at'] = null;
            }
        }

        $task->update($data);

        return $task;
    }

    /**
     * Soft delete task.
     */
    public function delete(Task $task): void
    {
        $task->delete();
    }
}