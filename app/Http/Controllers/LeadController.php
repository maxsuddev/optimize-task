<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeadRequest;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $query = Lead::where('user_id', auth()->id())
            ->with('tasks')
            ->search($request->search)
            ->filterByStatus($request->status)
            ->latest();

        $leads = $query->paginate(15)->withQueryString();

        return view('leads.index', compact('leads'));
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