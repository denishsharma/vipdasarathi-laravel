<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model {
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'level',
        'logo',
        'status',
    ];

    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(User::class);
    }

    public function level(): string {
        return match ($this->level) {
            'national' => 'National',
            'state' => 'State',
            'district' => 'District',
            'planning-others' => 'Planning (Others)',
        };
    }
}
