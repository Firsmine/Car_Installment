<?php

namespace App\Http\Controllers;

use App\Models\Validation;
use Illuminate\Http\Request;

class ValidationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'job' => 'required|string',
            'job_description' => 'required|string',
            'income' => 'required|integer|min:1',
            'reason_accepted' => 'required|string'
        ]);

        $validation = Validation::create([
            'society_id' => $request->user()->id,
            'status' => 'pending',
            'job' => $request->job,
            'job_description' => $request->job_description,
            'income' => $request->income,
            'reason_accepted' => $request->reason_accepted,
            'validator_id' => null,
            'validator_notes' => null
        ]);
        return response()->json([
            'message' => 'Request data validation sent successful',
        ], 200);
    }

    public function index(Request $request)
    {
        $validation = Validation::where('society_id', $request->user()->id)->with('validator')->first();

        return response()->json([
            'validation' => [
                'id' => $validation->id,
                'status' => $validation->status,
                'job' => $validation->job,
                'job_description' => $validation->job_description,
                'income' => $validation->income,
                'reason_accepted' => $validation->reason_accepted,
                'validator_notes' => $validation->validator_notes,
                'validator' => $validation->validator,
            ]
        ]);
    }
}
