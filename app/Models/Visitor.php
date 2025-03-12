<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'first_name',
        'last_name',
        'phone',
        'tc',
        'address',
        'visit_reason',
        'check_in',
        'check_out',
        'visit_approval'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
