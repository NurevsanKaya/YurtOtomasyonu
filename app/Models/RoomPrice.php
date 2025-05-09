<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'capacity',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];
} 