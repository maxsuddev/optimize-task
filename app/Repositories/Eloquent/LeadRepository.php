<?php

namespace App\Repositories\Eloquent;
use App\Http\Requests\LeadRequest;
use App\Models\Lead;
use App\Repositories\Contracts\LeadRepositoryInterface;
use Illuminate\Http\Request;

class LeadRepository implements LeadRepositoryInterface
{
    public function find($id)
    {
        // Implementation here
    }  
    
    
    public function all(Request $request)
    {
        $query = Lead::where('user_id', auth()->id())
            ->with('tasks')
            ->search($request->search)
            ->filterByStatus($request->status)
            ->latest();

        return  $query->paginate(15)->withQueryString();
    }


    public function store(LeadRequest $request)
    {
        // Implementation here
    }
    public function update($id, LeadRequest $lead)
    {
        // Implementation here
    }
    public function delete($id)
    {   
        // Implementation here
    }
}