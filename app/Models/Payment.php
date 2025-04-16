<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'amount', 'payment_date', 'payment_status', 'payment_type', 'due_date','debt_id'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function debt()
    {
        return $this->belongsTo(Debt::class);
    }

}
