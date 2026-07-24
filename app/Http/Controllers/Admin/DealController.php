<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use Illuminate\Http\Request;

class DealController extends Controller
{
    public function index()
    {
        $deals = Deal::latest()->paginate(10);
        return view('admin.deals.index', compact('deals'));
    }

    public function create()
    {
        return view('admin.deals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'end_date' => 'required|date|after:now',
            'is_active' => 'required|in:0,1',
            'badge_text' => 'nullable|max:255',
            'cta_text' => 'nullable|max:255',
            'cta_link' => 'nullable|max:500',
        ]);

        Deal::create($request->only([
            'title', 'description', 'end_date', 'is_active',
            'badge_text', 'cta_text', 'cta_link',
        ]));

        return redirect()->route('admin.deals.index')->with('success', 'Deal created successfully.');
    }

    public function edit(Deal $deal)
    {
        return view('admin.deals.edit', compact('deal'));
    }

    public function update(Request $request, Deal $deal)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'end_date' => 'required|date',
            'is_active' => 'required|in:0,1',
            'badge_text' => 'nullable|max:255',
            'cta_text' => 'nullable|max:255',
            'cta_link' => 'nullable|max:500',
        ]);

        $deal->update($request->only([
            'title', 'description', 'end_date', 'is_active',
            'badge_text', 'cta_text', 'cta_link',
        ]));

        return redirect()->route('admin.deals.index')->with('success', 'Deal updated successfully.');
    }

    public function destroy(Deal $deal)
    {
        $deal->delete();
        return redirect()->route('admin.deals.index')->with('success', 'Deal deleted successfully.');
    }
}
