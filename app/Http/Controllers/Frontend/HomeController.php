<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Watch;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the dynamic luxury showcase matrix.
     */
    public function index()
    {
        // Fetching latest watches from secure database registry
        $watches = Watch::latest()->get();

        
        return view('frontend.shop', compact('watches'));
    }

    /**
     * Display the individual horology masterpiece specifications.
     */
    public function show($id)
    {
        
        $watch = Watch::findOrFail($id);
        

        return view('frontend.products-details', compact('watch'));
    }
} 