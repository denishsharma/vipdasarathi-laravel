<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model {
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
        'activity_type_id',
        'user_id',
        'activity_category',
        'status',
        'raw',
        'activityable_id',
        'activityable_type',
    ];

    public function activityable(): \Illuminate\Database\Eloquent\Relations\MorphTo {
        return $this->morphTo();
    }

    public function activity_category(): string {
        return match ($this->activity_category) {
            'comment' => 'Comment Updates',
            'status' => 'Status Updates',
            'detail' => 'Details Updates',
        };
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function activityType(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(ActivityType::class);
    }

    public function attachments(): \Illuminate\Database\Eloquent\Relations\MorphMany {
        return $this->morphMany(Attachment::class, 'attachmentable');
    }
}
