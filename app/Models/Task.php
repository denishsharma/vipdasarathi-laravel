<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model {
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
        'priority',
        'disaster_case_id',
        'task_type_id',
        'task_category',
        'task_of_id',
        'status',
    ];

    public function priority(): string {
        return match ($this->priority) {
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High',
            'urgent' => 'Urgent',
        };
    }

    public function status(): string {
        return match ($this->status) {
            'active' => 'Active',
            'archived' => 'Archived',
            'completed' => 'Completed',
            default => 'Unknown',
        };
    }

    public function task_category(): string {
        return match ($this->task_category) {
            'general' => 'General Task',
            'demands' => 'Demand of Resources',
            'tickets' => 'Tickets',
        };
    }

    public function disaster_case(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(DisasterCase::class);
    }

    public function attachments(): \Illuminate\Database\Eloquent\Relations\MorphMany {
        return $this->morphMany(Attachment::class, 'attachmentable');
    }

    public function task_type(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(TaskType::class);
    }

    public function activities(): \Illuminate\Database\Eloquent\Relations\MorphMany {
        return $this->morphMany(Activity::class, 'activityable');
    }

    public function task_of(): ?\Illuminate\Database\Eloquent\Relations\BelongsTo {
        if ($this->task_category === 'tickets') {
            return $this->belongsTo(Ticket::class, 'task_of_id');
        }

        return null;
    }

    public function teams(): \Illuminate\Database\Eloquent\Relations\BelongsToMany {
        return $this->belongsToMany(Team::class);
    }

    public function tickets(): \Illuminate\Database\Eloquent\Relations\MorphMany {
        return $this->morphMany(Ticket::class, 'ticketable');
    }
}
