<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Plan extends Model
{
    protected $table = 'plans';
    protected $fillable = [
        'title',
        'price',
        'duration',
        'resolution',
        'max_device'
    ];
    // function relation one to many to 
    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class, 'plan_id', 'id');
    }

    // function relation hasmanytrough to UserModel
    public function users(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, Membership::class, 'plan_id', 'user_id');
    }
}
