<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use Illuminate\Http\Request;

class InstallmentController extends Controller
{
    public function index(Request $request)
    {
        $car = Installment::with('availableMonth:installment_id,month,description')->get();
        return response()->json([
            'cars' => $car
        ]);
    }

    public function show($id)
    {
        $car = Installment::with('availableMonth:installment_id,month,description')->findOrFail($id);
        return response()->json([
            'instalment' => $car
        ]);
    }
}
