<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('content.admin-profile.profile');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $admin = Auth::user();

        // Optional: check if this user is an admin
        if ($admin->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json([
            'message' => 'Admin profile fetched successfully.',
            'data' => $admin,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        /** @var \App\Models\User $admin */
        $admin = Auth::user();

        if ($admin->role !== 'admin') {
            return redirect()->route('admin.index')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Ensure name and email cannot be updated without password and confirmation
        if (!empty($request->input('name')) || !empty($request->input('email'))) {
            if (empty($request->input('password')) || empty($request->input('password_confirmation'))) {
                return redirect()->route('admin.index')->with('error', 'Password and confirmation are required to update name or email.');
            }
        }

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $admin->update($validated);

        return view('content.admin-profile.profile')->with('success', 'Admin profile updated successfully.');
    }

    public function changePassword()
    {
        return view('content.admin-profile.change-password');
    }
    public function SendchangePassword(Request $request)
    {
        /** @var \App\Models\User $admin */
        $admin = Auth::user();

        if ($admin->role !== 'admin') {
            return redirect()->route('admin.password-change')->with('error', 'Unauthorized');
        }

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Check if current password matches
        if (!Hash::check($request->current_password, $admin->password)) {
            return redirect()->route('admin.password-change')->with('error', 'Current password is incorrect.');
        }

        // Update the password
        $admin->password = bcrypt($request->new_password);
        $admin->save();

        return redirect()->route('admin.password-change')->with('success', 'Password changed successfully.');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
