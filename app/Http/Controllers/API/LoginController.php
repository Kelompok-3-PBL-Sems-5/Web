<?php

namespace App\Http\Controllers\Api;

use App\Models\UserModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        // Set validation rules
        $validator = Validator::make($request->all(), [
            'username_dosen' => 'required',
            'password_dosen' => 'required',
        ]);

        // If validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Attempt to find the user by username
        $dosen = UserModel::where('username_dosen', $request->username_dosen)->first();

        // Check if the user exists and the password matches
        if ($dosen && Hash::check($request->password_dosen, $dosen->password_dosen)) {
            // Return success response
            return response()->json([
                'success' => true,
                'dosen' => $dosen,
            ], 200);
        }

        // Return failure response
        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials',
        ], 401);
    }
}
