<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model {
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'filename',
        'original_filename',
        'attachmentable_id',
        'attachmentable_type',
    ];

    public function attachmentable(): \Illuminate\Database\Eloquent\Relations\MorphTo {
        return $this->morphTo();
    }
}
