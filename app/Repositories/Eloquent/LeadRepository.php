<?php

namespace App\Repositories\Eloquent;

use App\Http\Requests\LeadRequest;
use App\Models\Lead;
use App\Repositories\Contracts\LeadRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class LeadRepository implements LeadRepositoryInterface
{
    public function show(int $id): Lead
    {
        return Lead::with(['tasks' => fn($q) => $q->latest('created_at')])->findOrFail($id);
    }


    public function all(Request $request): LengthAwarePaginator
    {
        $query = Lead::where('user_id', auth()->id())
            ->withCount('tasks')
            ->withCount(['tasks as tasks_done_count' => function ($q) {
                $q->where('is_done', true);
            }])
            ->search($request->search)
            ->filterByStatus($request->status)
            ->latest('id');

        return  $query->paginate(10)->withQueryString();
    }


    public function store(LeadRequest $request): Lead
    {
        $lead = Lead::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
        ]);
        return $lead;
    }
    public function update(int $id, LeadRequest $lead): Lead
    {
        $leadModel = Lead::findOrFail($id);
        $leadModel->update($lead->validated());
        return $leadModel;
    }
    public function delete(int $id): bool
    {
        $lead = Lead::findOrFail($id);
        $lead->tasks()->delete();
        return $lead->delete();
    }
}
