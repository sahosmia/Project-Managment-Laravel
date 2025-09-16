<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->keyBy('key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'max_member' => 'required|integer|min:1',
        ]);

        Setting::where('key', 'max_member')->update(['value' => $request->max_member]);

        return back()->with('success', 'Settings updated successfully.');
    }
}
