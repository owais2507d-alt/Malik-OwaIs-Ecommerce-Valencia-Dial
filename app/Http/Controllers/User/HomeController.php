<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', 'active')->get();

        $topSellers = Product::with('category')
            ->where('status', 'active')
            ->where('stock', '>', 0)
            ->latest()
            ->take(4)
            ->get();

        $featured = Product::with('category')
            ->where('status', 'active')
            ->latest()
            ->take(3)
            ->get();

        return view('user.home', compact('categories', 'topSellers', 'featured'));
    }
}
