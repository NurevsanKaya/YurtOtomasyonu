<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    // Eğer tablo ismi tekil ise belirtmemiz gerekir
    protected $table = 'permission';

    // Formdan gelecek ve doldurulmasına izin verilen alanlar
    protected $fillable = [
        'user_id',
        'description',
        'start_date',
        'end_date',
        'phone_number',
        'destination_address',
    ];

    // Kullanıcı ilişkisi: Bir izin bir kullanıcıya aittir
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
