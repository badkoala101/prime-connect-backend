<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fund;

class FundController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'target_amount' => 'required|numeric|min:0',
        ]);

        $campaign = Fund::create($validatedData);

        return response()->json($campaign, 201);
    }

    public function index()
    {
        $campaigns = Fund::all();

        return response()->json($campaigns);
    }
    public function contribute(Request $request, $id)
    {
    $request->validate([
        'amount' => 'required|numeric|min:1',
    ]);

    $campaign = Fund::findOrFail($id);
    $campaign->raised_amount += $request->input('amount');
    $campaign->save();

    return response()->json(['message' => 'Contribution successful'], 200);
    }

}
