<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'address',
        'phone_number',
        'kebele_id',
        'bank_account',
        'loan_amount',
        'status',
    ];
    

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}