<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'title',
        'due_at',
        'is_done',
    ];

    protected $casts = [
        'due_at' => 'datetime',
        'is_done' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function isOverdue(): bool
    {
        if (!$this->due_at || $this->is_done) {
            return false;
        }

        return $this->due_at->isPast();
    }
}
