<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeadRequest;
use App\Models\Lead;
use App\Repositories\Contracts\LeadRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LeadController extends Controller
{
    use AuthorizesRequests;

    protected $leadRepository;
    public function __construct(LeadRepositoryInterface $leadRepository)
    {
        $this->leadRepository = $leadRepository;
    }   
  
    public function index(Request $request)
    {
        try {

            $leads = $this->leadRepository->all($request);
    
            return view('leads.index', compact('leads'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('messages.error') . $e->getMessage());
        }
    }

    public function create()
    {
        return view('leads.create');
    }

    public function store(LeadRequest $request)
    {
        try {
            $lead = $this->leadRepository->store($request);
    
            return redirect()
                ->route('leads.show', $lead)
                ->with('success', __('messages.success_store_lead'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('messages.error') . $e->getMessage());
        }
    }

    public function show(Lead $lead)
    {
        try {
            $lead = $this->leadRepository->show($lead->id);
    
            return view('leads.show', compact('lead'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('messages.error') . $e->getMessage());
        }
    }

    public function edit(Lead $lead)
    {
        $this->authorize('update', $lead);

        return view('leads.edit', compact('lead'));
    }


    public function update(LeadRequest $request, Lead $lead)
    {
        try {
            $updatedLead = $this->leadRepository->update($lead->id, $request);
    
            return redirect()
                ->route('leads.show', $updatedLead)
                ->with('success', __('messages.success_update_lead'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('messages.error') . $e->getMessage());
        }
    }

    public function destroy(Lead $lead)
    {
        try {
            $this->authorize('delete', $lead);
            $this->leadRepository->delete($lead->id);
    
            return redirect()
                ->route('leads.index')
                ->with('success', __('messages.success_delete_lead'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('messages.error') . $e->getMessage());
        }
    }
}