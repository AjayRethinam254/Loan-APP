<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KycDetail extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'client_id',
        'aadhar_number',
        'pan_number',
        'bank_name',
        'account_number',
        'account_holder_name',
        'ifsc_code',
        'branch_name',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
