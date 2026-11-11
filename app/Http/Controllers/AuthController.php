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
    }
}
