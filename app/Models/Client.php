<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'client_name',
        'user_id',
        'client_email',
        'client_phone',
        'alternate_phone',
        'address',
        'date_of_birth',
        'gender',
        'marital_status',
        'cibil_score',
        'lead_by',
        'is_active',
        'is_deleted',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'lead_by');
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    protected static function booted()
    {
        static::creating(function ($client) {
            if (!isset($client->user_id)) {
                $user = User::create([
                    'name' => $client->name ?? 'Guest',
                    'phone' => $client->phone,
                    'role_id' => 3,
                    'email' => $client->email ?? null,
                ]);

                $client->user_id = $user->id;
            }
        });
    }
    
}

