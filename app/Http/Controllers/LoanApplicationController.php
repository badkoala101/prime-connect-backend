<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoanApplication;

class LoanApplicationController extends Controller
{
    /**
     * Store a new loan application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'kebele_id' => 'required|string|max:50',
            'bank_account' => 'required|numeric|digits_between:9,18',
            'amount' => 'required|numeric|min:0',
        ]);

        // Create a new loan application
        $loanApplication = LoanApplication::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'address' => $validatedData['address'],
            'phone_number' => $validatedData['phone_number'],
            'kebele_id' => $validatedData['kebele_id'],
            'bank_account' => $validatedData['bank_account'],
            'amount' => $validatedData['amount'],
        ]);

        // Return a success response
        return response()->json([
            'message' => 'Loan application submitted successfully!',
            'loanApplication' => $loanApplication,
        ], 201);
    }

    /**
     * Fetch all loan applications.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Retrieve all loan applications
        $loanApplications = LoanApplication::all();

        // Return a success response with loan applications data
        return response()->json($loanApplications);
    }
}
