<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NocDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_application_id',
        'noc_type',
        'file_name',
        'file_path',
        'issued_by',
        'issue_date',
        'remarks',
    ];

    public function loanApplication()
    {
        return $this->belongsTo(LoanApplication::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'issued_by');
    }
}
