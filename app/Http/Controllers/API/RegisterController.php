<?php

namespace App\Http\Controllers\Api;

use App\Models\Dosen;
use App\Http\Controllers\Controller;
use App\Models\DosenModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        // Set validation rules
        $validator = Validator::make($request->all(), [
            'nama_dosen' => 'required',
            'username_dosen' => 'required|unique:data_dosen,username_dosen',
            'password_dosen' => 'required|min:5|confirmed',
            'nidn_dosen' => 'required|unique:data_dosen,nidn_dosen',
            'email_dosen' => 'required|email|unique:data_dosen,email_dosen',
            'gelar_akademik' => 'nullable',
        ]);

        // If validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create a new dosen user
        $dosen = DosenModel::create([
            'nama_dosen' => $request->nama_dosen,
            'username_dosen' => $request->username_dosen,
            'password_dosen' => bcrypt($request->password_dosen),
            'nidn_dosen' => $request->nidn_dosen,
            'email_dosen' => $request->email_dosen,
            'gelar_akademik' => $request->gelar_akademik,
        ]);

        // Return response JSON if dosen is created
        if ($dosen) {
            return response()->json([
                'success' => true,
                'dosen' => $dosen,
            ], 201);
        }

        // Return JSON if insert fails
        return response()->json([
            'success' => false,
        ], 409);
    }
}
