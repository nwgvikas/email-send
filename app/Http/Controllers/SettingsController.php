<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function edit(): View
    {
        $setting = SiteSetting::query()->first();

        return view('settings.edit', [
            'setting' => $setting,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_name' => ['required', 'string', 'max:120'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'favicon' => ['nullable', 'file', 'mimes:ico,png,gif,jpg,jpeg,webp,svg', 'max:512'],
        ]);

        $row = SiteSetting::query()->first() ?? new SiteSetting;
        $row->site_name = $validated['site_name'];

        if ($request->hasFile('logo')) {
            if ($row->logo_path) {
                Storage::disk('public')->delete($row->logo_path);
            }
            $row->logo_path = $request->file('logo')->store('site', 'public');
        }

        if ($request->hasFile('favicon')) {
            if ($row->favicon_path) {
                Storage::disk('public')->delete($row->favicon_path);
            }
            $row->favicon_path = $request->file('favicon')->store('site', 'public');
        }

        $row->save();

        return redirect()
            ->route('settings.edit')
            ->with('status', 'General settings saved successfully.');
    }
}
