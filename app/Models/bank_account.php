<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bank_account extends Model
{
    
    use HasFactory;
    protected $fillable = [
        'user_id',
        'balance',
    ];
    // protected $table ="bank_accounts";
    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

