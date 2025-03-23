<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model
{
    protected $fillable = [
        'name',
        'skill_level',
        'gender',
        'strength',
        'speed',
        'reaction_time',
    ];
    protected $appends = ['formatted_date'];
    protected $casts = [
        'created_at' => 'datetime', 
    ];

    public function wonTournaments(): HasMany
    {
        return $this->hasMany(Tournament::class, 'winner_id');
    }
    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d-m-Y H:i:s');
    }
}
