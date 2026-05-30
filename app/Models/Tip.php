<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tip extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'match_teams',
        'prediction',
        'odds',
        'status',
        'match_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}