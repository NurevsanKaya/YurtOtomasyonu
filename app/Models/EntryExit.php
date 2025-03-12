<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntryExit extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'check_in', 'check_out', 'reason', 'approval_status'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
