<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens; // Import Sanctum trait
use App\Models\Notification;
use Jenssegers\Agent\Agent; // Add this library for device detection

class RegisterController extends Controller
{
    use HasApiTokens; // Use Sanctum trait

    public function register(Request $request)
    {
        // Add 'name' to the validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Include 'name' in the user creation process
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Create a token for the user
        $token = $user->createToken('Personal Access Token')->plainTextToken;
        // Create a notification
        Notification::create([
            'user_id' => $user->id, // Link the notification to the new user
            'message' => 'Welcome to Prime Connect, ' . $user->name . '! Your account has been successfully created.',
        //     'read' => false,
        ]);
        Notification::create([
            'user_id' => $user->id, 
            'message' => 'Hi '. $user->name .' Please finish up filling Verifiy id section to use our products.',
        //     'read' => false,
        ]);

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Create a token for the user
            $token = $user->createToken('Personal Access Token')->plainTextToken;
            
            // Detect the device
            $agent = new Agent();
            $deviceType = $agent->isMobile() ? 'Mobile' : ($agent->isTablet() ? 'Tablet' : 'Desktop');
            $platform = $agent->platform();
            $browser = $agent->browser();

            // Create a notification with the device name
            Notification::create([
                'user_id' => $user->id,
                'message' => 'You have signed in from a ' . $deviceType . ' device using ' . $platform . ' and ' . $browser .'.',
            ]);
            Notification::create([
                'user_id' => $user->id, 
                'message' => 'Please finish up filling Verifiy id section to use our products.',
            //     'read' => false,
            ]);

            return response()->json([
                'user' => $user,
                'token' => $token
            ], 200);
        } else {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }
}
