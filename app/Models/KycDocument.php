<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KycDocument extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'kyc_id',
        'client_id',
        'aadhar_front',
        'aadhar_back',
        'pan_card',
        'passbook',
        'is_verified',
        'status',
        'remarks',
    ];

    public function kycDetail()
    {
        return $this->belongsTo(KycDetail::class, 'kyc_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
