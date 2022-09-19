<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model {
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'subject',
        'description',
        'status',
        'user_id',
        'disaster_case_id',
        'task_id',
        'ticketable_id',
        'ticketable_type',
    ];

    public function status(): string {
        return match ($this->status) {
            'open' => 'Open',
            'closed' => 'Closed',
            'task' => 'In Progress (Task)',
            default => 'Unknown',
        };
    }

    public function has_task(): bool {
        return $this->task_id !== null;
    }

    public function ticketable(): \Illuminate\Database\Eloquent\Relations\MorphTo {
        return $this->morphTo();
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function disaster_case(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(DisasterCase::class);
    }

    public function task(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Task::class);
    }

    public function attachments(): \Illuminate\Database\Eloquent\Relations\MorphMany {
        return $this->morphMany(Attachment::class, 'attachmentable');
    }
}
