<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    // Show all services
    public function index()
    {
        $services = Service::paginate(10);
        return view('content.services.service', compact('services'));
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
