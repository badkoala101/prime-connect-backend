<?php
namespace App\Http\Controllers;

use App\Models\bank_account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankAccountController extends Controller
{
    public function check()
    {
        $user = Auth::user();

        // Fetch the bank balance for the authenticated user
        $balance = bank_account::where('user_id', $user->id)->value('balance'); // Fetching a single balance

        if ($balance !== null) {
            return response()->json(['balance' => $balance]);
        } else {
            return response()->json(['error' => 'Balance not found'], 404); // Return error if balance not found
        }
    }
}
