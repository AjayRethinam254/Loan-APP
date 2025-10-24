<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoanSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'loan_id',
        'loan_application_id',
        'due_date',
        'installment_amount',
        'principal_amount',
        'interest_amount',
        'outstanding_amount',
        'status',
        'payment_id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function loanApplication()
    {
        return $this->belongsTo(LoanApplication::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
    //
}
