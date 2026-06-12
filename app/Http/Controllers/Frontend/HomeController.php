<?php

namespace App\Http\Controllers\Frontend;
use App\Models\Watch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
public function index(){
    $watches =Watch::latest()->get();


    return view('shop', compact('watches'));
}
public function show($id)
{
    $watch = Watch::findOrFail($id);
    return view('show', compact('watch'));
}
}
