<?php

namespace App\Http\Controllers;

use App\Models\bank_account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class BankAccountController extends Controller
{
   
   //
    public function check()
    {
        $user = Auth::user();

        // Fetch bank balance for the authenticated user
        $balance = bank_account::where('user_id', $user->id)->get('balance');

        return response()->json($balance);
    }
}


