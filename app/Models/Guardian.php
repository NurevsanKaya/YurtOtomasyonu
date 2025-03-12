<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'first_name', 'last_name', 'phone', 'relationship', 'email'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
