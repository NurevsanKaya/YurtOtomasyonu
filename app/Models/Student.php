<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'tc', 'phone', 'email',
        'address_id', 'birth_date', 'registration_date', 'room_id',
         'medical_condition', 'emergency_contact', 'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
     public function complaintRequests()
    {
        return $this->hasMany(ComplaintRequest::class);
    }
    public function entryExits()
    {
        return $this->hasMany(EntryExit::class);
    }
    public function guardians()
    {
        return $this->hasMany(Guardian::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function visitors()
    {
        return $this->hasMany(Visitor::class);
    }
    public function debts()
    {
        return $this->hasMany(Debt::class);
    }

}
