<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable =
        ['room_number',
            'capacity',
            'floor',
            'current_occupants',
            'room_type',
            'price'
        ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
