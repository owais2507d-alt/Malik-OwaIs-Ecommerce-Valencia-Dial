<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class HeroSettingsController extends Controller
{
    public function index()
    {
        return view('admin.hero-settings.index');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'hero_title' => 'nullable|string|max:255',
            'hero_title_accent' => 'nullable|string|max:255',
            'hero_tagline' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:500',
            'hero_cta_primary_text' => 'nullable|string|max:255',
            'hero_cta_primary_link' => 'nullable|string|max:500',
            'hero_cta_secondary_text' => 'nullable|string|max:255',
            'hero_cta_secondary_link' => 'nullable|string|max:500',
            'hero_video' => 'nullable|string|max:1000',
        ]);

        foreach ($data as $key => $value) {
            Setting::setValue($key, $value);
        }

        return redirect()->route('admin.hero-settings.index')
            ->with('success', 'Hero section updated successfully.');
    }
}
