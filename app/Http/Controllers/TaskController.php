<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Lead;
use App\Models\Task;

class TaskController extends Controller
{
    use \Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    public function store(TaskRequest $request, Lead $lead)
    {
        $lead->tasks()->create(
            $request->validated()
            );

        return redirect()
            ->route('leads.show', $lead)
            ->with('success', 'Задача успешно создана');
    }

    public function toggle(Task $task)
    {
        $this->authorize('update', $task->lead);

        $task->update([
            'is_done' => !$task->is_done
        ]);

        return redirect()
            ->route('leads.show', $task->lead)
            ->with('success', 'Статус задачи обновлен');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task->lead);

        $lead = $task->lead;
        $task->delete();

        return redirect()
            ->route('leads.show', $lead)
            ->with('success', 'Задача успешно удалена');
    }
}