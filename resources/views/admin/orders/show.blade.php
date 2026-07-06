@extends('layouts.admin')

@section('title', "Order {$order->order_number}")

@push('styles')
<style>
    .status-badge-lg {
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding: 0.375rem 1rem;
        border-radius: 999px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .status-pending { background: #fef3c7; color: #92400e; }
    .status-confirmed { background: #dbeafe; color: #1e40af; }
    .status-processing { background: #e0e7ff; color: #3730a3; }
    .status-shipped { background: #dbeafe; color: #1e40af; }
    .status-delivered { background: #dcfce7; color: #166534; }
    .status-cancelled { background: #fef2f2; color: #991b1b; }
    .info-label {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #9ca3af;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    .info-value {
        font-size: 0.9rem;
        color: #374151;
        font-weight: 500;
    }
</style>
@endpush

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ route('admin.orders.index') }}" class="text-gray-500 hover:text-gray-700 text-sm inline-flex items-center gap-2 mb-4">
                <i class="fas fa-arrow-left text-xs"></i>
                Back to Orders
            </a>
            <div class="flex items-center gap-4">
                <h2 class="text-3xl font-bold text-gray-800 font-mono">{{ $order->order_number }}</h2>
                <span class="status-badge-lg status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
            </div>
            <p class="text-gray-500 mt-1">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl mb-6 flex items-center gap-3">
        <i class="fas fa-check-circle text-green-500"></i>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Items -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-wider">Order Items</h3>
                <div class="divide-y divide-gray-50">
                    @foreach($order->items as $item)
                    <div class="flex items-center gap-4 py-4 first:pt-0 last:pb-0">
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-800">{{ $item->product_name }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">${{ number_format($item->product_price, 2) }} x {{ $item->quantity }}</p>
                        </div>
                        <span class="font-semibold text-gray-800">${{ number_format($item->subtotal, 2) }}</span>
                    </div>
                    @endforeach
                </div>
                <div class="border-t border-gray-100 pt-4 mt-2 flex justify-between items-center">
                    <span class="text-sm font-bold text-gray-800 uppercase tracking-wider">Total</span>
                    <span class="text-xl font-bold text-gray-900">${{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Update Status -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-wider">Update Status</h3>
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <select name="status" class="w-full p-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-blue-400 mb-4">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-3 rounded-xl transition-all">
                        Update Status
                    </button>
                </form>
            </div>

            <!-- Shipping Details -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-wider">Shipping Details</h3>
                <div class="space-y-3">
                    <div>
                        <p class="info-label">Name</p>
                        <p class="info-value">{{ $order->shipping_name }}</p>
                    </div>
                    <div>
                        <p class="info-label">Phone</p>
                        <p class="info-value">{{ $order->shipping_phone }}</p>
                    </div>
                    <div>
                        <p class="info-label">Address</p>
                        <p class="info-value">{{ $order->shipping_address }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <p class="info-label">City</p>
                            <p class="info-value">{{ $order->shipping_city }}</p>
                        </div>
                        <div>
                            <p class="info-label">Postal Code</p>
                            <p class="info-value">{{ $order->shipping_postal_code ?? '—' }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="info-label">Country</p>
                        <p class="info-value">{{ $order->shipping_country }}</p>
                    </div>
                </div>
            </div>

            <!-- Payment Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-wider">Payment</h3>
                <div class="space-y-3">
                    <div>
                        <p class="info-label">Method</p>
                        <p class="info-value">{{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Credit Card' }}</p>
                    </div>
                    <div>
                        <p class="info-label">Status</p>
                        <p class="info-value">{{ ucfirst($order->payment_status) }}</p>
                    </div>
                </div>
            </div>

            <!-- Customer Info -->
            @if($order->user)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-wider">Customer</h3>
                <div class="space-y-3">
                    <div>
                        <p class="info-label">Name</p>
                        <p class="info-value">{{ $order->user->name }}</p>
                    </div>
                    <div>
                        <p class="info-label">Email</p>
                        <p class="info-value">{{ $order->user->email }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
