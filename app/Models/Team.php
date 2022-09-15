<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model {
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'name',
        'description',
        'team_type_id',
        'status',
    ];

    public function status(): string {
        return match ($this->status) {
            'active' => 'Active',
            'inactive' => 'Inactive',
            default => 'Unknown',
        };
    }

    public function team_type(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(TeamType::class);
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany {
        return $this->belongsToMany(User::class);
    }
}
