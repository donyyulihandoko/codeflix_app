<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    protected $table = 'ratings';
    protected $fillable = [
        'user_id',
        'movie_id',
        'rating'
    ];

    // function relation to Movie Model
    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class, 'movie_id', 'id');
    }

    // function relation to User Model
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
