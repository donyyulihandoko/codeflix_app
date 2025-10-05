<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    protected $table = 'movies';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'director',
        'writers',
        'stars',
        'poster',
        'release_date',
        'duration',
        'url_780p',
        'url_1080p',
        'url_4k'
    ];

    protected $casts = [
        'release_date' => 'date'
    ];

    // function relation many to many to Category Model
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_movie', 'movie_id', 'category_id');
    }

    // function relation one to many to Rating Model
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class, 'movie_id', 'id');
    }

    // function get avg rating
    public function getAverageRatingAttribute(): float
    {
        return $this->ratings()->avg('rating');
    }
}
