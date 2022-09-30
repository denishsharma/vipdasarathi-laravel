<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisasterCaseMetadata extends Model {
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'disaster_case_id',
        'casualties',
        'raw',
    ];

    public function get_casualties(): \Illuminate\Support\Collection {
        return collect(json_decode($this->casualties, true))->put('total', json_decode($this->casualties, true)['rescued'] + json_decode($this->casualties, true)['deaths']);
    }

    public function disaster_case(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(DisasterCase::class);
    }
}
