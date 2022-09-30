<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisasterCase extends Model {
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'title',
        'description',
        'happened_at',
        'disaster_type_id',
        'priority',
        'status',
    ];

    public function disaster_type(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(DisasterType::class);
    }

    public function address(): \Illuminate\Database\Eloquent\Relations\MorphOne {
        return $this->morphOne(Address::class, 'addressable');
    }

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
            'pending' => 'Pending',
            'active' => 'Active',
            'closed' => 'Closed',
        };
    }

    public function disaster_case_metadata(): \Illuminate\Database\Eloquent\Relations\HasOne {
        return $this->hasOne(DisasterCaseMetadata::class);
    }

    public function tasks(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(Task::class);
    }

    public function teams(): \Illuminate\Database\Eloquent\Relations\BelongsToMany {
        return $this->belongsToMany(Team::class);
    }

    public function demands(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(Demand::class);
    }

    public function activities(): \Illuminate\Database\Eloquent\Relations\MorphMany {
        return $this->morphMany(Activity::class, 'activityable');
    }

    public function has_many_tickets(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(Ticket::class);
    }

    public function shelters(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(Shelter::class);
    }
}
