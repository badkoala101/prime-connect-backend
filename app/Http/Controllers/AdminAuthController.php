<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Attempt to authenticate
        $admin = Admin::where('username', $request->username)->first();

        if ($admin && $admin->password === $request->password) {
            // Create a token for the admin
            $token = $admin->createToken('Admin Access Token')->plainTextToken;

            return response()->json([
                'admin' => $admin,
                'token' => $token
            ], 200);
        } else {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }
}
