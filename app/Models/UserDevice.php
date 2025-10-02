<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDevice extends Model
{
    /** @use HasFactory<\Database\Factories\UserDeviceFactory> */
    // use HasFactory;
    protected $table = 'user_devices';
    protected $fillable = [
        'user_id',
        'device_name',
        'device_id',
        'device_type',
        'platform',
        'platform_version',
        'browser',
        'browser_version',
        'last_active'
    ];

    protected $casts = [
        'last_active' => 'datetime'
    ];
    // function relasi ke User Model
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
