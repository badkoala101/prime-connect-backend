<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function apply(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'kebele_id' => 'required|string|max:20',
            'bank_account' => 'required|string|max:30',
            'loan_amount' => 'required|numeric|min:1',
        ]);

        // Create a new loan application
        $loan = Loan::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'kebele_id' => $request->kebele_id,
            'bank_account' => $request->bank_account,
            'loan_amount' => $request->loan_amount,
        ]);

        return response()->json(['message' => 'Loan application submitted successfully!', 'loan' => $loan], 201);
    }
}
