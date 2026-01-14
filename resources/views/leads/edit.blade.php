@extends('panel.layouts.app')
@section('title', 'Lead')
@section('page', __('pageText.leads'))
    @section('content')
@if(session('success'))
    <div id="autoCloseAlert" class="alert alert-success alert-dismissible">
        {{ session('success') }}
    </div>
@endif
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="mb-4">
            <a href="{{ route('leads.show', $lead) }}" class="text-decoration-none text-muted mb-2 d-block">
                <i class="bi bi-arrow-left"></i> {{__('pageText.backToLeadDetails')}}
            </a>
            <h1 class="h3">{{__('pageText.edit')}}</h1>
            <p class="text-muted">{{ __('pageText.lead_edit_description') }}</p>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('leads.update', $lead) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="full_name" class="form-label">
                            {{ __('pageText.full_name') }} <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('full_name') is-invalid @enderror" 
                               id="full_name" 
                               name="full_name" 
                               value="{{ old('full_name', $lead->full_name) }}">
                        @error('full_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">
                            {{ __('pageText.phone') }} <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone', $lead->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">
                            {{ __('pageText.status') }} <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" 
                                name="status">
                            <option value="new" {{ old('status', $lead->status) === 'new' ? 'selected' : '' }}>Новый</option>
                            <option value="in_progress" {{ old('status', $lead->status) === 'in_progress' ? 'selected' : '' }}>В работе</option>
                            <option value="done" {{ old('status', $lead->status) === 'done' ? 'selected' : '' }}>Завершен</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="note" class="form-label">{{ __('pageText.note') }}</label>
                        <textarea class="form-control @error('note') is-invalid @enderror" 
                                  id="note" 
                                  name="note" 
                                  rows="4">{{ old('note', $lead->note) }}</textarea>
                        @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> {{__('pageText.save')}}
                        </button>
                        <a href="{{ route('leads.show', $lead) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg"></i> {{__('pageText.cancel')}}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection