<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    protected $table = 'addresses';

    use HasFactory;

    protected $fillable =
        ['address_line',
        'postal_code',
        'district_id'];

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
