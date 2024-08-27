<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;

class AdminLoanController extends Controller
{
    // Get all loans
    public function index()
    {
        $loans = Loan::all();
        return response()->json($loans);
    }

    // Get a specific loan
    public function show($id)
    {
        $loan = Loan::find($id);
        if (!$loan) {
            return response()->json(['message' => 'Loan not found'], 404);
        }
        return response()->json($loan);
    }

    // Create a new loan (if necessary)
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'kebele_id' => 'required|string|max:20',
            'bank_account' => 'required|string|max:30',
            'loan_amount' => 'required|numeric|min:1',
        ]);

        $loan = Loan::create($request->all());

        return response()->json($loan, 201);
    }

    // Update a loan (e.g., approve/reject)
    public function update(Request $request, $id)
    {
        $loan = Loan::find($id);
        if (!$loan) {
            return response()->json(['message' => 'Loan not found'], 404);
        }

        $request->validate([
            'status' => 'required|string',
        ]);

        $loan->status = $request->status;
        $loan->save();

        return response()->json($loan);
    }

    // Delete a loan
    public function destroy($id)
    {
        $loan = Loan::find($id);
        if (!$loan) {
            return response()->json(['message' => 'Loan not found'], 404);
        }

        $loan->delete();

        return response()->json(['message' => 'Loan deleted']);
    }
}
