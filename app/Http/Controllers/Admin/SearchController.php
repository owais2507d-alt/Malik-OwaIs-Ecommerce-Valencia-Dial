<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return redirect()->back()->with('error', 'Enter at least 2 characters to search.');
        }

        $products = Product::with('category')
            ->where('name', 'like', "%{$query}%")
            ->orWhere('brand', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->take(5)
            ->get();

        $orders = Order::with('user')
            ->where('order_number', 'like', "%{$query}%")
            ->orWhere('shipping_name', 'like', "%{$query}%")
            ->orWhere('shipping_phone', 'like', "%{$query}%")
            ->orWhere('shipping_email', 'like', "%{$query}%")
            ->take(5)
            ->get();

        $categories = Category::where('name', 'like', "%{$query}%")
            ->take(5)
            ->get();

        return view('admin.search.results', compact('query', 'products', 'orders', 'categories'));
    }
}
