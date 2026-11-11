<?php

namespace App\Http\Controllers;

use App\Models\Society;
use Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'id_card_number',
            'password'
        ]);
        $society = Society::where('id_card_number', $request->id_card_number)->first();

        if (!$society || Hash::check($society->password, $request->password)) {
            return response()->json([
                'message' => 'ID card number or password incorrect'
            ]);
        }

        $society->tokens->delete();
        $token = $society->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => [
                'name' => $society->name,
                'born_date' => $society->born_date,
                'gender' => $society->gender,
                'address' => $society->address,
                'token' => $token,
                'regional' => $society->regional ? [
                    'id' => $society->regional->id,
                    'province' => $society->regional->province,
                    'district' => $society->regional->district,
                ] : []
            ]
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken->delete();
        return response()->json([
            'message' => 'Logout success'
        ]);
    }
}
