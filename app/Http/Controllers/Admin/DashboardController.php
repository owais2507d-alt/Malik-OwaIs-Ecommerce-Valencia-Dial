<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalUsers = User::count();
        $activeProducts = Product::where('status', 'active')->count();
        $totalStock = Product::sum('stock');
        $lowStock = Product::where('stock', '>', 0)->where('stock', '<=', 5)->count();

        $orderStats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'revenue' => Order::whereIn('status', ['delivered', 'shipped', 'confirmed'])->sum('total'),
        ];

        $recentOrders = Order::with('user')->latest()->take(5)->get();

        // Real chart data for last 6 months
        $revenueData = [];
        $monthLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthLabels[] = $month->format('M');
            $revenueData[] = (float) Order::whereIn('status', ['delivered', 'shipped', 'confirmed'])
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total');
        }

        // Category distribution for doughnut chart
        $categories = Category::withCount('products')->where('status', 'active')->get();
        $categoryLabels = $categories->pluck('name')->toArray();
        $categoryData = $categories->pluck('products_count')->toArray();
        $categoryColors = ['#2563eb', '#4f46e5', '#6366f1', '#818cf8', '#a78bfa', '#c4b5fd', '#94a3b8'];

        if (empty($categoryLabels)) {
            $categoryLabels = ['No Categories'];
            $categoryData = [1];
            $categoryColors = ['#94a3b8'];
        }

        return view('admin.dashboard', compact(
            'totalProducts', 'totalCategories', 'totalUsers',
            'activeProducts', 'totalStock', 'lowStock',
            'orderStats', 'recentOrders',
            'revenueData', 'monthLabels',
            'categoryLabels', 'categoryData', 'categoryColors'
        ));
    }

}
