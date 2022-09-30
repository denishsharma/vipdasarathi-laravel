<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demand extends Model {
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
        'demand_type_id',
        'decision',
        'items',
        'raw',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, array>
     */
    protected $casts = [
        'items' => 'array',
        'raw' => 'array',
    ];

    public function status(): string {
        return match ($this->status) {
            'open' => 'Open',
            'closed' => 'Closed',
            default => 'Unknown',
        };
    }

    public function decision(): string {
        return match ($this->decision) {
            'accepted' => 'Accepted',
            'rejected' => 'Rejected',
            default => 'Unknown',
        };
    }

    public function demand_type(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(DemandType::class);
    }

    public function disaster_case(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(DisasterCase::class);
    }

    public function task(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Task::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(User::class);
    }
}
