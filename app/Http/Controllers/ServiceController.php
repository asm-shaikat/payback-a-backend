<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    // Show all services
    public function index(Request $request)
    {
        $query = Service::where('scam_type', '!=', 'Contact Us');

        // Apply filters
        if ($request->filled('scam_type')) {
            $query->where('scam_type', $request->input('scam_type'));
        }

        if ($request->filled('transaction_type')) {
            $query->where('transaction_type', $request->input('transaction_type'));
        }

        // Get paginated services
        $services = $query->paginate(10)->appends($request->all());

        // Fetch unique values for dropdowns (excluding 'Contact Us')
        $scamTypes = Service::where('scam_type', '!=', 'Contact Us')
            ->select('scam_type')->distinct()->pluck('scam_type');

        $transactionTypes = Service::select('transaction_type')->distinct()->pluck('transaction_type');

        return view('content.services.service', compact('services', 'scamTypes', 'transactionTypes'));
    }








    // Show form to create a new service
    public function create()
    {
        return view('services.create');
    }

    // Store new service in database
    public function store(Request $request)
    {
        $request->validate([
            'fname' => 'nullable|string|max:255',
            'lname' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'scam_type' => 'nullable|string|max:255',
            'transaction_type' => 'nullable|string|max:255',
            'scam_amount' => 'nullable|string|max:255',
            'scam_description' => 'nullable|string',
        ]);

        Service::create($request->all());

        return redirect()->route('services.index')->with('success', 'Service created successfully.');
    }

    // Show a specific service
    public function show($id)
    {
        $service = Service::findOrFail($id);
        return response()->json($service);
    }

    // Show edit form
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('services.edit', compact('service'));
    }

    // Update the service
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'fname' => 'nullable|string|max:255',
            'lname' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'scam_type' => 'nullable|string|max:255',
            'transaction_type' => 'nullable|string|max:255',
            'scam_amount' => 'nullable|string|max:255',
            'scam_description' => 'nullable|string',
        ]);

        $service->update($request->all());

        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

    // Delete the service
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }
}
