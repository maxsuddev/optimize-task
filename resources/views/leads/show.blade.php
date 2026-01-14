@extends('panel.layouts.app')
@section('title', 'Lead')
@section('page', __('pageText.leads'))
    @section('content')
@if(session('success'))
    <div id="autoCloseAlert" class="alert alert-success alert-dismissible">
        {{ session('success') }}
    </div>
@endif
<div class="row">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="{{ route('leads.index') }}" class="text-decoration-none text-muted mb-2 d-block">
                    <i class="bi bi-arrow-left"></i> Назад к списку
                </a>
                <h1 class="h3 mb-0">{{ $lead->full_name }}</h1>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('leads.edit', $lead) }}" class="btn btn-outline-primary">
                    <i class="bi bi-pencil"></i> Редактировать
                </a>
                <form method="POST" action="{{ route('leads.destroy', $lead) }}" 
                      onsubmit="return confirm('Вы уверены, что хотите удалить этот лид?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="bi bi-trash"></i> Удалить
                    </button>
                </form>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3">Информация о лиде</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="text-muted small">Телефон</label>
                        <p class="mb-0">{{ $lead->phone }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Статус</label>
                        <p class="mb-0">
                            <span class="badge {{ $lead->getStatusBadgeClass() }}">
                                {{ $lead->getStatusLabel() }}
                            </span>
                        </p>
                    </div>
                    <div class="col-12">
                        <label class="text-muted small">Дата создания</label>
                        <p class="mb-0">{{ $lead->created_at->format('d.m.Y H:i') }}</p>
                    </div>
                    @if($lead->note)
                        <div class="col-12">
                            <label class="text-muted small">Заметка</label>
                            <p class="mb-0">{{ $lead->note }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Задачи ({{ $lead->tasks->count() }})</h5>
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                    <i class="bi bi-plus-lg"></i> Добавить задачу
                </button>
            </div>
            <div class="card-body">
                @if($lead->tasks->isEmpty())
                    <div class="text-center py-4">
                        <i class="bi bi-list-task display-4 text-muted"></i>
                        <p class="text-muted mt-2">Задач пока нет</p>
                    </div>
                @else
                    <div class="list-group list-group-flush">
                        @foreach($lead->tasks as $task)
                            <div class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="d-flex align-items-start flex-grow-1">
                                    <form method="POST" action="{{ route('tasks.toggle', $task) }}" class="me-3">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $task->is_done ? 'btn-success' : 'btn-outline-secondary' }}">
                                            <i class="bi {{ $task->is_done ? 'bi-check-circle-fill' : 'bi-circle' }}"></i>
                                        </button>
                                    </form>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 {{ $task->is_done ? 'text-decoration-line-through text-muted' : '' }}">
                                            {{ $task->title }}
                                        </h6>
                                        <div class="small text-muted">
                                            @if($task->due_at)
                                                <i class="bi bi-calendar-event"></i>
                                                <span class="{{ $task->isOverdue() ? 'text-danger fw-bold' : '' }}">
                                                    {{ $task->due_at->format('d.m.Y H:i') }}
                                                </span>
                                                @if($task->isOverdue())
                                                    <span class="badge bg-danger ms-1">Просрочено</span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('tasks.destroy', $task) }}" 
                                      onsubmit="return confirm('Удалить эту задачу?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addTaskModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('leads.tasks.store', $lead) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Новая задача</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">
                            Название задачи <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title') }}"
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="due_at" class="form-label">Срок выполнения</label>
                        <input type="datetime-local" 
                               class="form-control @error('due_at') is-invalid @enderror" 
                               id="due_at" 
                               name="due_at" 
                               value="{{ old('due_at') }}">
                        @error('due_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary">Создать задачу</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($errors->any())
     <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modalEl = document.getElementById('addTaskModal');
            if (modalEl) {
                var modal = new bootstrap.Modal(modalEl);
                modal.show();
            }
        });
    </script>
@endif
@endsection