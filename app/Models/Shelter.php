<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shelter extends Model {
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'disaster_case_id',
        'name',
        'description',
        'shelter_type_id',
        'status',
        'raw',
    ];

    protected $casts = [
        'raw' => 'array',
    ];

    public function disaster_case(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(DisasterCase::class);
    }

    public function shelter_type(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(ShelterType::class);
    }

    public function address(): \Illuminate\Database\Eloquent\Relations\MorphOne {
        return $this->morphOne(Address::class, 'addressable');
    }
}
