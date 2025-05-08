<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'visit_approval' => 'boolean'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
