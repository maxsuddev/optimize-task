<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeadRequest;
use App\Models\Lead;
use App\Repositories\Contracts\LeadRepositoryInterface;
use Illuminate\Http\Request;

class LeadController extends Controller
{
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
            return redirect()
                ->back()
                ->with('error', 'Ошибка при загрузке лидов: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('leads.create');
    }

    public function store(LeadRequest $request)
    {
        $lead = Lead::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('leads.show', $lead)
            ->with('success', 'Лид успешно создан');
    }

    public function show(Lead $lead)
    {
        
        $lead->load(['tasks' => function ($query) {
            $query->latest();
        }]);

        return view('leads.show', compact('lead'));
    }

    public function edit(Lead $lead)
    {
        $this->authorize('update', $lead);

        return view('leads.edit', compact('lead'));
    }

    public function update(LeadRequest $request, Lead $lead)
    {
        $lead->update($request->validated());

        return redirect()
            ->route('leads.show', $lead)
            ->with('success', 'Лид успешно обновлен');
    }

    public function destroy(Lead $lead)
    {
        $this->authorize('delete', $lead);

        $lead->delete();

        return redirect()
            ->route('leads.index')
            ->with('success', 'Лид успешно удален');
    }
}