<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'country',
        'region',
        'zone',
        'city',
        'woreda',
        'kebele',
        'house_number',
        'street_address',
        'address_type',
        'address_duration',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

