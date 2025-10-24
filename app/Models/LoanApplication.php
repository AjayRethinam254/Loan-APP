<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoanApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'company_name',
        'company_address',
        'position',
        'monthly_income',
        'employment_type',
    ];
    
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    
}
