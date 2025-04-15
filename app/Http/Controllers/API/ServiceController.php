<?php

namespace App\Http\Controllers\API;


use App\Models\Service;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        return response()->json(Service::all(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fname' => 'nullable|string|max:255',
            'lname' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'scam_type' => 'nullable|string|max:255',
            'transaction_type' => 'nullable|string|max:255',
            'scam_amount' => 'nullable|string|max:255',
            'scam_description' => 'nullable|string',
        ]);

        $service = Service::create($validated);

        return response()->json(['message' => 'Service created successfully', 'data' => $service], 201);
    }
}
