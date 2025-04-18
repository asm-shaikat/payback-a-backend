<?php

namespace App\Http\Controllers\API;


use App\Models\Service;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::query();

        // Apply filters if present
        if ($request->has('scam_type')) {
            $query->where('scam_type', $request->input('scam_type'));
        }

        if ($request->has('transaction_type')) {
            $query->where('transaction_type', $request->input('transaction_type'));
        }

        return response()->json($query->get(), 200);
    }


    public function getByEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $services = Service::where('email', $request->email)->get();

        return response()->json([
            'status' => 'success',
            'email' => $request->email,
            'total' => $services->count(),
            'data' => $services
        ]);
    }



    public function store(Request $request)
    {
        // Decode raw JSON
        $data = json_decode($request->getContent(), true);

        // Validate manually
        $validated = validator($data, [
            'fname' => 'nullable|string|max:255',
            'lname' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'subject' => 'nullable|string',
            'scam_type' => 'nullable|string|max:255',
            'transaction_type' => 'nullable|string|max:255',
            'scam_amount' => 'nullable|string|max:255',
            'scam_description' => 'nullable|string',
        ])->validate();

        // Create the service
        $service = Service::create($validated);

        // Return JSON response
        return response()->json([
            'message' => 'Service created successfully',
            'data' => $service
        ], 201);
    }

    // public function store(Request $request)
    // {
    //     $faker = Faker::create();

    //     for ($i = 0; $i < 100; $i++) {
    //         DB::table('services')->insert([
    //             'fname' => $faker->firstName,
    //             'lname' => $faker->lastName,
    //             'phone' => $faker->phoneNumber,
    //             'email' => $faker->unique()->safeEmail,
    //             'scam_type' => $faker->randomElement(['Online Fraud', 'Investment Scam', 'Fake Job', 'UPI Scam']),
    //             'transaction_type' => $faker->randomElement(['UPI', 'Credit Card', 'Bank Transfer']),
    //             'scam_amount' => $faker->numberBetween(1000, 100000),
    //             'scam_description' => $faker->sentence(10),
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ]);
    //     }

    //     return response()->json([
    //         'message' => 'Random fake service stored successfully.'
    //     ]);
    // }
}
