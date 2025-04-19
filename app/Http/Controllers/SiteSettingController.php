<?php


namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function edit()
    {
        $setting = SiteSetting::firstOrCreate([]);
        return view('content.site-settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'contact_number' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|max:2048'
        ]);

        $setting = SiteSetting::first();

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $setting->logo = $logoPath;
        }

        $setting->update($request->only(['site_name', 'contact_number', 'email', 'address']));
        $setting->save();

        return back()->with('success', 'Settings updated successfully!');
    }
}
