<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomChangeRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'current_room_id',
        'requested_room_id',
        'status',
        'admin_message',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currentRoom()//mevcut oda
    {
        return $this->belongsTo(Room::class, 'current_room_id');
    }

    public function requestedRoom()//talep edilen oda
    {
        return $this->belongsTo(Room::class, 'requested_room_id');
    }
}
