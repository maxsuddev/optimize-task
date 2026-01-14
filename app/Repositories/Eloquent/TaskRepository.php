<?php

namespace App\Repositories\Eloquent;
use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;

class TaskRepository implements TaskRepositoryInterface
{
    public function store(array $data)
    {
        return Task::create($data);
    }

    public function toggle(int $id): bool
    {
        $task = Task::findOrFail($id);
        $task->is_done = !$task->is_done;
        return $task->save();
    }

    public function delete(int $id): bool
    {
        return Task::destroy($id);
    }
}