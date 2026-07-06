@extends('layouts.admin')

<title>Search Results | Valencia Admin</title>

@section('content')
<div class="bg-gray-50/80 antialiased">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 space-y-8">

        <div>
            <h1 class="text-3xl font-semibold text-gray-800">Search Results</h1>
            <p class="text-gray-600 mt-1">Showing results for "<strong>{{ $query }}</strong>"</p>
        </div>

        @if($products->isEmpty() && $orders->isEmpty() && $categories->isEmpty())
            <div class="card bg-white border border-gray-100 rounded-3xl p-12 shadow-xs text-center">
                <i class="fas fa-search text-5xl text-gray-300 mb-4"></i>
                <h2 class="text-xl font-semibold text-gray-600">No results found</h2>
                <p class="text-gray-400 mt-1">Try different keywords or browse using the sidebar.</p>
            </div>
        @endif

        @if($products->isNotEmpty())
        <div class="card bg-white border border-gray-100 rounded-3xl p-6 shadow-xs">
            <h2 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-box text-blue-500"></i> Products ({{ $products->count() }})
            </h2>
            <div class="divide-y divide-gray-100">
                @foreach($products as $product)
                <a href="{{ route('admin.products.edit', $product) }}" class="flex items-center justify-between py-3 hover:bg-gray-50/50 px-2 rounded-lg transition-colors">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $product->name }}</p>
                        <p class="text-xs text-gray-500">{{ $product->brand }} · ${{ number_format($product->price, 2) }} · Stock: {{ $product->stock }}</p>
                    </div>
                    <span class="text-xs font-bold text-blue-600">Edit →</span>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        @if($orders->isNotEmpty())
        <div class="card bg-white border border-gray-100 rounded-3xl p-6 shadow-xs">
            <h2 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-shopping-bag text-amber-500"></i> Orders ({{ $orders->count() }})
            </h2>
            <div class="divide-y divide-gray-100">
                @foreach($orders as $order)
                <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center justify-between py-3 hover:bg-gray-50/50 px-2 rounded-lg transition-colors">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $order->order_number }}</p>
                        <p class="text-xs text-gray-500">{{ $order->shipping_name }} · ${{ number_format($order->total, 2) }}</p>
                    </div>
                    <span class="text-xs font-bold text-blue-600">View →</span>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        @if($categories->isNotEmpty())
        <div class="card bg-white border border-gray-100 rounded-3xl p-6 shadow-xs">
            <h2 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-tags text-emerald-500"></i> Categories ({{ $categories->count() }})
            </h2>
            <div class="divide-y divide-gray-100">
                @foreach($categories as $category)
                <a href="{{ route('admin.categories.edit', $category) }}" class="flex items-center justify-between py-3 hover:bg-gray-50/50 px-2 rounded-lg transition-colors">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $category->name }}</p>
                        <p class="text-xs text-gray-500">{{ ucfirst($category->status) }}</p>
                    </div>
                    <span class="text-xs font-bold text-blue-600">Edit →</span>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
