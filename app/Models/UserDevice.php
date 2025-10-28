<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_type',
        'device_id',
        'device_model',
        'device_name',
        'latitude',
        'longitude',
        'ip_address',
    ];

    /**
     * Polymorphic relation to Client or Agent.
     */
    public function user()
    {
        return $this->morphTo();
    }
}
