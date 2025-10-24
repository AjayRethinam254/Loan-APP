<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'agent_name',
        'agent_email',
        'agent_phone',
        'agent_code',
        'address',
        'city',
        'district',
        'state',
        'pincode',
        'status',
        'is_deleted',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }
}
