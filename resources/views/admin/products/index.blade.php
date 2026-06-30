@extends('layouts.admin')

@section('title', 'Products')

@push('styles')
<style>
    .product-img {
        width: 56px;
        height: 56px;
        object-fit: cover;
        border-radius: 12px;
    }
    .stock-badge {
        font-size: 0.7rem;
        letter-spacing: 0.05em;
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        font-weight: 500;
    }
    .stock-in {
        background: #dcfce7;
        color: #166534;
    }
    .stock-out {
        background: #fef2f2;
        color: #991b1b;
    }
    .status-indicator {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }
    .status-active { background: #22c55e; }
    .status-inactive { background: #9ca3af; }
    .action-btn {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.2s;
        border: none;
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Products</h2>
            <p class="text-gray-500 mt-1">Manage your product inventory</p>
        </div>
        <a href="{{ route('admin.products.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl text-sm font-medium transition-all inline-flex items-center gap-2">
            <i class="fas fa-plus"></i>
            New Product
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl mb-6 flex items-center gap-3">
        <i class="fas fa-check-circle text-green-500"></i>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-4">Product</th>
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-4">Brand</th>
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-4">Category</th>
                        <th class="text-right text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-4">Price</th>
                        <th class="text-center text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-4">Stock</th>
                        <th class="text-center text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-4">Status</th>
                        <th class="text-right text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-img">
                                @else
                                    <div class="product-img bg-gray-100 flex items-center justify-center text-gray-400">
                                        <i class="fas fa-box text-sm"></i>
                                    </div>
                                @endif
                                <div>
                                    <span class="font-medium text-gray-800">{{ $product->name }}</span>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ Str::limit($product->description, 50) ?? '—' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $product->brand ?? '—' }}</td>
                        <td class="px-6 py-4">
                            @if($product->category)
                                <span class="text-sm text-gray-600">{{ $product->category->name }}</span>
                            @else
                                <span class="text-sm text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right font-semibold text-gray-800">${{ number_format($product->price, 2) }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="stock-badge {{ $product->stock > 0 ? 'stock-in' : 'stock-out' }}">
                                {{ $product->stock > 0 ? $product->stock . ' in stock' : 'Out of stock' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="status-indicator {{ $product->status === 'active' ? 'status-active' : 'status-inactive' }}"></span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="action-btn bg-blue-50 text-blue-600 hover:bg-blue-100"
                                   title="Edit">
                                    <i class="fas fa-pen text-xs"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                      onsubmit="return confirm('Delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn bg-red-50 text-red-500 hover:bg-red-100" title="Delete">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <i class="fas fa-box-open text-4xl text-gray-300"></i>
                                <p class="text-gray-500 font-medium">No products yet</p>
                                <a href="{{ route('admin.products.create') }}" class="text-blue-600 text-sm hover:underline">Add your first product</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
