<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    // Show the form to add new setting
    public function create()
    {
        return view('content.settings');
    }

    // Store new setting
    public function store(Request $request)
    {
        $request->validate([
            'module' => 'required|string|max:255',
            'key' => 'required|string|max:255',
            'value' => 'required|string|max:255',
        ]);

        Setting::create([
            'module' => $request->module,
            'key' => $request->key,
            'value' => $request->value,
        ]);

        return redirect()->route('settings.create')->with('success', 'Setting added successfully!');
    }
}
