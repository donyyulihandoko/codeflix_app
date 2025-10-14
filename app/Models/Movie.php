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
        'url_720',
        'url_1080',
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

    // function get url resolution movie
    public function getUrlMovie(string $planResolution)
    {
        if ($planResolution === '720p') {
            return $this->url_720;
        } elseif ($planResolution === '1080') {
            return $this->url_1080;
        } elseif ($planResolution === '4k') {
            return $this->url_4k;
        } else {
            return $this->url_720;
        }
    }
}
