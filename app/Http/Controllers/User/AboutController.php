<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $categoryCount = Category::where('status', 'active')->count();
        $productCount = Product::where('status', 'active')->count();
        $stockCount = Product::where('status', 'active')->sum('stock');

        return view('user.about', compact('categoryCount', 'productCount', 'stockCount'));
    }
}
