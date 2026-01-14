@extends('panel.layouts.app')
@section('title', 'Lead')
@section('page', __('pageText.leads'))
    @section('content')
@if(session('success'))
    <div id="autoCloseAlert" class="alert alert-success alert-dismissible">
        {{ session('success') }}
    </div>
@endif
<div class="d-flex justify-content-between align-items-center mb-4">
    <div></div>
    <a href="{{ route('leads.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> {{__('pageText.lead_create')}}
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('leads.index') }}" class="row g-3">
            <div class="col-md-5">
                <label class="form-label">{{__('pageText.search')}}</label>
                <input type="text" name="search" class="form-control" 
                       placeholder="Имя или телефон" 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">{{__('pageText.status')}}</label>
                <select name="status" class="form-select">
                    <option value="">{{__('pageText.all_statuses')}}</option>
                    <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>{{__('pageText.lead_status_new')}}</option>
                    <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>{{__('pageText.lead_status_in_progress')}}</option>
                    <option value="done" {{ request('status') === 'done' ? 'selected' : '' }}>{{__('pageText.lead_status_done')}}</option>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> {{__('pageText.find')}}
                </button>
                <a href="{{ route('leads.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-lg"></i> {{__('pageText.reset')}}
                </a>
            </div>
        </form>
    </div>
</div>

@if($leads->isEmpty())
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="bi bi-inbox display-1 text-muted"></i>
            <h4 class="mt-3">{{__('pageText.no_leads_found')}}</h4>
            <a href="{{ route('leads.create') }}" class="btn btn-primary mt-2">
                {{__('pageText.lead_create')}}
            </a>
        </div>
    </div>
@else
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>{{__('pageText.full_name')}}</th>
                        <th>{{__('pageText.phone')}}</th>
                        <th>{{__('pageText.status')}}</th>
                        <th>{{__('pageText.tasks')}}</th>
                        <th>{{__('pageText.created_at')}}</th>
                        <th width="100"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leads as $lead)
                        <tr>
                            <td>{{ $lead->id }}</td>
                            <td>
                                <a href="{{ route('leads.show', $lead) }}" class="text-decoration-none fw-semibold">
                                    {{ $lead->full_name }}
                                </a>
                            </td>
                            <td>{{ $lead->phone }}</td>
                            <td>
                                <span class="badge {{ $lead->getStatusBadgeClass() }}">
                                    {{ $lead->getStatusLabel() }}
                                </span>
                            </td>
                            <td>
                                @if($lead->tasks_total > 0)
                                <span class="badge bg-secondary">
                                    {{ $lead->tasks_done }}/{{ $lead->tasks_total }}
                                </span>
                                @else
                                <span class="text-muted">—</span>
                                @endif
                            </td>

                            <td>{{ $lead->created_at->format('d.m.Y H:i') }}</td>
                            <td>
                                <a href="{{ route('leads.show', $lead) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

  <div class="col-12">
                    <nav aria-label="Page navigation" class="justify-content-center">
                        {{$leads->links('pagination::bootstrap-5')}}
                    </nav>
 </div>

@endif
    @endsection
