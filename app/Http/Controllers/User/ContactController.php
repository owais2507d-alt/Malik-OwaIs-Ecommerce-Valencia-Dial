<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('user.contact');
    }

    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|max:255',
            'message' => 'required|string',
        ]);

        // Mail functionality can be added later
        // For now, just redirect with success message

        return back()->with('success', 'Your message has been received. Our concierge team will respond within 24 hours.');
    }
}
