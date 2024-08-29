<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalInformation;
use App\Models\Address;
use App\Models\Notification; // Import Notification model
use Auth;

class VerifyIdController extends Controller
{
    public function storePersonalInfo(Request $request)
    {
        // Validate request
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'birth_date' => 'required|date',
            'marital_status' => 'nullable|string',
            'phone_number' => 'required|string|max:15',
            'id_number' => 'required|string|max:255',
            'account_number' => 'required|string|max:15',
        ]);

        // Check if the user already submitted their personal info
        $existingPersonalInfo = PersonalInformation::where('user_id', Auth::id())->first();

        if ($existingPersonalInfo) {
            return response()->json(['error' => 'You have already submitted your personal information.'], 403);
        }

        // Store personal information
        $personalInfo = PersonalInformation::create([
            'user_id' => Auth::id(),
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'marital_status' => $request->marital_status,
            'phone_number' => $request->phone_number,
            'id_number' => $request->id_number,
            'account_number' => $request->account_number,
        ]);

        return response()->json(['personal_info' => $personalInfo]);
    }

    public function storeAddressInfo(Request $request)
    {
        // Validate request
        $request->validate([
            'country' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'zone' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'woreda' => 'nullable|string|max:255',
            'kebele' => 'nullable|string|max:255',
            'house_number' => 'nullable|string|max:255',
            'street_address' => 'nullable|string|max:255',
            'address_type' => 'required|in:commercial,residential',
            'address_duration' => 'required|in:permanent,temporary',
        ]);

        // Check if the user already submitted their address info
        $existingAddressInfo = Address::where('user_id', Auth::id())->first();

        if ($existingAddressInfo) {
            return response()->json(['error' => 'You have already submitted your address information.'], 403);
        }

        // Store address information
        $addressInfo = Address::create([
            'user_id' => Auth::id(),
            'country' => $request->country,
            'region' => $request->region,
            'zone' => $request->zone,
            'city' => $request->city,
            'woreda' => $request->woreda,
            'kebele' => $request->kebele,
            'house_number' => $request->house_number,
            'street_address' => $request->street_address,
            'address_type' => $request->address_type,
            'address_duration' => $request->address_duration,
        ]);

        // Create notification when address info is successfully stored
        Notification::create([
            'user_id' => Auth::id(),
            'message' => 'Thank you for completing the Verify ID form. You can now use our products.',
            'read' => false,
        ]);

        return response()->json(['address_info' => $addressInfo]);
    }

    public function fetchUserInfo($id)
    {
        // Retrieve personal and address information based on the provided user ID
        $personalInfo = PersonalInformation::where('user_id', $id)->first();
        $addressInfo = Address::where('user_id', $id)->first();

        // Return the information as a JSON response
        return response()->json([
            'personal_info' => $personalInfo,
            'address_info' => $addressInfo,
        ]);
    }

    public function fetchLoggedInUserInfo()
    {
        $userId = Auth::id();
        $personalInfo = PersonalInformation::where('user_id', $userId)->first();
        $addressInfo = Address::where('user_id', $userId)->first();

        return response()->json([
            'personal_info' => $personalInfo,
            'address_info' => $addressInfo,
        ]);
    }
}
