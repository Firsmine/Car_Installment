<?php

namespace App\Http\Controllers;

use App\Models\AvailableMonth;
use App\Models\Installment;
use App\Models\JobApplyPosition;
use App\Models\JobApplySociety;
use App\Models\Validation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'instalment_id' => 'required|exists:installment,id',
            'months' => 'required|integer',
            'notes' => 'string|nullable',
        ]);

        // invalid field
        // $validator = Validator::make($request->all(), $data);
        // if (!$validator) {
        //     return response()->json([
        //         'message' => 'invalid field',
        //         'errors' => $validator->errors()
        //     ], 422);
        // }

        // check status
        $validation = Validation::where('society_id', Auth::id())->where('status', 'accepted')->first();
        if (!$validation) {
            return response()->json([
                'message' => 'Your data validator must be accepted by validator before'
            ], 401);
        }

        // apply twice
        if (JobApplySociety::where('society_id', Auth::id())->exists()) {
            return response()->json([
                'message' => 'Application for a installment can only be once'
            ], 401);
        }

        // month
        $availableMonth = AvailableMonth::where('installment_id', $request->instalment_id)->where('month', $request->months)->first();
        if (!$availableMonth) {
            return response()->json([
                'message' => 'The selected months is not available for this installment'
            ], 400);
        }

        // income
        // if ((int) $validation->income < (int) $availableMonth->nominal) {
        //     return response()->json([
        //         'message' => 'Income does not meet the monthly payment'
        //     ], 400);
        // }

        JobApplySociety::create([
            'notes' => $request->notes,
            'available_month_id' => $availableMonth->id,
            'date' => now(),
            'society_id' => Auth::id(),
            'installment_id' => $request->instalment_id
        ]);

        return response()->json([
            'message' => 'Applying for installment successful'
        ], 200);
    }

    public function index(Request $request)
    {
        // $instalment = Installment::where('society_id', Auth::id())->with('application')->get();

        $instalment = Installment::whereHas('application', function ($query) {
            $query->where('society_id', Auth::id());
        })->with([
                    'application' =>
                        function ($query) {
                            $query->where('society_id', Auth::id());
                        }
                ])->get();

        return response()->json([
            'instalments' => $instalment
        ]);
        // return response()->json([
        //     'instalments' => [
        //         'id' => $instalment->id,
        //         'car' => $instalment->car,
        //         'brand' => $instalment->brand,
        //         'price' => $instalment->price,
        //         'description' => $instalment->description,
        //         'application' => [
        //             $instalment->application
        //         ]
        //     ]
        // ]);
    }
}
