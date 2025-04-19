<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = SiteSetting::first();
        return response()->json([
            'status' => 'success',
            'data' => $settings
        ]);
    }


    public function getDropdownOptions(Request $request)
    {
        $request->validate([
            'module' => 'required|string',
            'key' => 'required|string',
        ]);

        $options = Setting::where('module', $request->module)
            ->where('key', $request->key)
            ->pluck('value');

        return response()->json([
            'status' => 'success',
            'module' => $request->module,
            'key' => $request->key,
            'options' => $options
        ]);
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
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
