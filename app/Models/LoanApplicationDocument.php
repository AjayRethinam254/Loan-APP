<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class LoanApplicationDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'loan_application_id',
        'document_type',
        'file_name',
        'file_path',
        'mime_type',
        'file_size',
        'uploaded_by',
        'verified_by',
        'verification_status',
        'remarks',
        'uploaded_at',
        'verified_at',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function loanApplication()
    {
        return $this->belongsTo(LoanApplication::class);
    }

    public function uploadedByAgent()
    {
        return $this->belongsTo(Agent::class, 'uploaded_by');
    }

    public function verifiedByAgent()
    {
        return $this->belongsTo(Agent::class, 'verified_by');
    }
    
}
