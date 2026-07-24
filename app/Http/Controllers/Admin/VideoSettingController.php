<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoSettingController extends Controller
{
    public function index()
    {
        $videoSectionUrl = Setting::getValue('video_section_url', '');
        $videoSectionFile = Setting::getValue('video_section_file', '');
        $videoSectionSubtitle = Setting::getValue('video_section_subtitle', 'Watch');
        $videoSectionTitle = Setting::getValue('video_section_title', 'THE CRAFT BEHIND THE CRAFT');
        $videoSectionDescription = Setting::getValue('video_section_description', '');

        return view('admin.video-settings.index', compact(
            'videoSectionUrl', 'videoSectionFile', 'videoSectionSubtitle', 'videoSectionTitle', 'videoSectionDescription'
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'video_section_url' => 'nullable|string|max:500',
            'video_section_file' => 'nullable|mimes:mp4,webm,ogg,avi,mov|max:204800',
            'video_section_subtitle' => 'nullable|string|max:200',
            'video_section_title' => 'nullable|string|max:200',
            'video_section_description' => 'nullable|string|max:1000',
            'remove_video_file' => 'nullable|in:1',
        ]);

        Setting::setValue('video_section_url', $request->video_section_url ?? '');
        Setting::setValue('video_section_subtitle', $request->video_section_subtitle ?? '');
        Setting::setValue('video_section_title', $request->video_section_title ?? '');
        Setting::setValue('video_section_description', $request->video_section_description ?? '');

        if ($request->hasFile('video_section_file')) {
            $oldFile = Setting::getValue('video_section_file', '');
            if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                Storage::disk('public')->delete($oldFile);
            }

            $path = $request->file('video_section_file')->store('videos', 'public');
            Setting::setValue('video_section_file', $path);
        }

        if ($request->remove_video_file === '1') {
            $oldFile = Setting::getValue('video_section_file', '');
            if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                Storage::disk('public')->delete($oldFile);
            }
            Setting::setValue('video_section_file', '');
        }

        return redirect()->route('admin.video-settings.index')->with('success', 'Video section settings saved.');
    }
}
