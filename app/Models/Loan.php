<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loan extends Model
{
    protected $fillable = [
        'loan_name',
        'loan_type',
        'loan_code',
        'min_amount',
        'max_amount',
        'interest_rate',
        'min_tenture',
        'max_tenture',
        'description',
        'is_active',
    ];

    public function loanApplications()
    {
        return $this->hasMany(LoanApplication::class);
    }

    public function nocDocuments()
    {
        return $this->hasMany(NocDocument::class);
    }
    
}
