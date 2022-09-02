<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model {
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'address_line_1',
        'address_line_2',
        'district',
        'city',
        'state',
        'country',
        'zipcode',
        'geo_data',
        'addressable_id',
        'addressable_type',
    ];

    public function addressable(): \Illuminate\Database\Eloquent\Relations\MorphTo {
        return $this->morphTo();
    }
}
