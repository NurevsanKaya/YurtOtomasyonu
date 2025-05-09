<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'debt_id',
        'amount',
        'payment_date',
        'payment_status',
        'payment_type',
        'receipt_path',
        'rejection_reason',
        'due_date'
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'due_date' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function debt()
    {
        return $this->belongsTo(Debt::class);
    }
}
