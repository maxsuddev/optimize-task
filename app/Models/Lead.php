<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'full_name',
        'phone',
        'status',
        'note',
        'user_id',
    ];

   
    //  protected $appends = ['tasks_total', 'tasks_done'];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function scopeSearch($query, ?string $search)
    {
        if (!$search) {
            return $query;
        }
        return $query->where(function ($q) use ($search) {
            $q->where('full_name', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    public function scopeFilterByStatus($query, ?string $status)
    {
        if (!$status) {
            return $query;
        }
        return $query->where('status', $status);
    }

    public function getStatusBadgeClass(): string
    {
        return match ($this->status) {
            'new' => 'bg-primary',
            'in_progress' => 'bg-warning',
            'done' => 'bg-success',
            default => 'bg-secondary',
        };
    }

    public function getStatusLabel(): string
    {
        return match ($this->status) {
            'new' => __('pageText.lead_status_new'),
            'in_progress' => __('pageText.lead_status_in_progress'),
            'done' => __('pageText.lead_status_done'),
            default => $this->status,
        };
    }


  public function getTasksTotalAttribute()
    {
        return $this->tasks_count ?? 0; 
    }

    public function getTasksDoneAttribute()
    {
        return $this->tasks_done_count ?? 0;
    }

}
