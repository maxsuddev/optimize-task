@extends('panel.layouts.app')
@section('title', 'Lead/Create')
@section('page', __('pageText.lead_create'))
    @section('content')
@if(session('success'))
    <div id="autoCloseAlert" class="alert alert-success alert-dismissible">
        {{ session('success') }}
    </div>
@endif
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="mb-4">
            <p class="text-muted">{{ __('pageText.lead_create_description') }}</p>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('leads.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="full_name" class="form-label">
                            {{ __('pageText.full_name') }}
                             <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('full_name') is-invalid @enderror" 
                               id="full_name" 
                               name="full_name" 
                               value="{{ old('full_name') }}"
                               placeholder="{{ __('pageText.full_name_plc') }}">
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
                               value="{{ old('phone') }}"
                               placeholder="+998901234567">
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
                            <option value="new" {{ old('status', 'new') === 'new' ? 'selected' : '' }}>{{ __('pageText.lead_status_new') }}</option>
                            <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>{{ __('pageText.lead_status_in_progress') }}</option>
                            <option value="done" {{ old('status') === 'done' ? 'selected' : '' }}>{{ __('pageText.lead_status_done') }}</option>
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
                                  rows="4"
                                  placeholder="{{ __('pageText.note_plc') }}">{{ old('note') }}</textarea>
                        @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> {{ __('pageText.lead_create') }}
                        </button>
                        <a href="{{ route('leads.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg"></i> {{ __('pageText.cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
