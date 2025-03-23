<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tournament extends Model
{
    protected $fillable = [
        'type',
        'date',
        'winner_id',
    ];
    protected $appends = ['formatted_date'];
    protected $casts = [
        'date' => 'datetime', 
    ];

    public function winner(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'winner_id');
    }


    public function getFormattedDateAttribute()
    {
        return $this->date->format('d-m-Y H:i:s');
    }
}