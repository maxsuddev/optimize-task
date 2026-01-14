<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Lead;
use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public TaskRepositoryInterface $taskRepository;
    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }
    public function store(TaskRequest $request, Lead $lead)
    {
        try {
            $this->taskRepository->store([
                ...$request->validated(),
                'lead_id' => $lead->id,
            ]);

            return redirect()
                ->route('leads.show', $lead)
                ->with('success', __('messages.success_store_task'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('messages.error') . $e->getMessage());
        }
    }

    public function toggle(Task $task)
    {
        try {
            $this->authorize('update', $task->lead);
            $this->taskRepository->toggle($task->id);

            return redirect()
                ->route('leads.show', $task->lead)
                ->with('success', __('messages.success_toggle_task'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('messages.error') . $e->getMessage());
        }
    }

    public function destroy(Task $task)
    {
        try {
            $this->authorize('delete', $task->lead);
            $this->taskRepository->delete($task->id);

            return redirect()
                ->route('leads.show', $task->lead)
                ->with('success', __('messages.success_delete_task'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('messages.error') . $e->getMessage());
        }
    }
}