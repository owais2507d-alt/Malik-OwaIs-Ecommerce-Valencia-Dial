<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $slides = Slide::orderBy('order')->paginate(10);
        return view('admin.slides.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.slides.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'subtitle' => 'nullable|max:255',
            'description' => 'nullable|string',
            'cta_text' => 'nullable|max:255',
            'cta_link' => 'nullable|max:500',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'is_active' => 'required|in:0,1',
            'order' => 'required|integer|min:0',
        ]);

        $imagePath = $request->file('image')->store('slides', 'public');

        Slide::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'cta_text' => $request->cta_text,
            'cta_link' => $request->cta_link,
            'image' => $imagePath,
            'is_active' => $request->is_active,
            'order' => $request->order,
        ]);

        return redirect()->route('admin.slides.index')->with('success', 'Slide created successfully.');
    }

    public function edit(Slide $slide)
    {
        return view('admin.slides.edit', compact('slide'));
    }

    public function update(Request $request, Slide $slide)
    {
        $request->validate([
            'title' => 'required|max:255',
            'subtitle' => 'nullable|max:255',
            'description' => 'nullable|string',
            'cta_text' => 'nullable|max:255',
            'cta_link' => 'nullable|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'is_active' => 'required|in:0,1',
            'order' => 'required|integer|min:0',
        ]);

        $imagePath = $slide->image;
        if ($request->hasFile('image')) {
            if ($slide->image) {
                Storage::disk('public')->delete($slide->image);
            }
            $imagePath = $request->file('image')->store('slides', 'public');
        }

        $slide->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'cta_text' => $request->cta_text,
            'cta_link' => $request->cta_link,
            'image' => $imagePath,
            'is_active' => $request->is_active,
            'order' => $request->order,
        ]);

        return redirect()->route('admin.slides.index')->with('success', 'Slide updated successfully.');
    }

    public function destroy(Slide $slide)
    {
        if ($slide->image) {
            Storage::disk('public')->delete($slide->image);
        }
        $slide->delete();

        return redirect()->route('admin.slides.index')->with('success', 'Slide deleted successfully.');
    }
}
