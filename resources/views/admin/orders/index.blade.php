@extends('layouts.admin')

@section('title', 'Orders')

@push('styles')
<style>
    .status-badge {
        font-size: 0.7rem;
        letter-spacing: 0.05em;
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }
    .status-pending { background: #fef3c7; color: #92400e; }
    .status-confirmed { background: #dbeafe; color: #1e40af; }
    .status-processing { background: #e0e7ff; color: #3730a3; }
    .status-shipped { background: #dbeafe; color: #1e40af; }
    .status-delivered { background: #dcfce7; color: #166534; }
    .status-cancelled { background: #fef2f2; color: #991b1b; }
    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
    }
    .status-dot-pending { background: #d97706; }
    .status-dot-confirmed { background: #2563eb; }
    .status-dot-processing { background: #4f46e5; }
    .status-dot-shipped { background: #2563eb; }
    .status-dot-delivered { background: #16a34a; }
    .status-dot-cancelled { background: #dc2626; }
    .filter-btn {
        padding: 0.5rem 1rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
        transition: all 0.2s;
        border: 1px solid transparent;
    }
    .filter-btn.active {
        background: #1e3a8a;
        color: white;
        border-color: #1e3a8a;
    }
    .filter-btn:not(.active) {
        background: white;
        color: #6b7280;
        border-color: #e5e7eb;
    }
    .filter-btn:not(.active):hover {
        border-color: #93c5fd;
        color: #1e3a8a;
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Orders</h2>
            <p class="text-gray-500 mt-1">Manage customer orders</p>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl mb-6 flex items-center gap-3">
        <i class="fas fa-check-circle text-green-500"></i>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Status Filter Tabs -->
    <div class="flex flex-wrap gap-2 mb-6">
        <a href="{{ route('admin.orders.index') }}"
           class="filter-btn {{ !request('status') ? 'active' : '' }}">
            All ({{ array_sum($statusCounts) }})
        </a>
        @foreach(['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'] as $s)
            <a href="{{ route('admin.orders.index', ['status' => $s]) }}"
               class="filter-btn {{ request('status') === $s ? 'active' : '' }}">
                {{ ucfirst($s) }} ({{ $statusCounts[$s] }})
            </a>
        @endforeach
    </div>

    <!-- Search -->
    <form method="GET" class="mb-6">
        <div class="flex gap-3">
            <div class="relative flex-1 max-w-md">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                       class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-blue-400"
                       placeholder="Search by order #, name, or phone...">
            </div>
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-3 rounded-xl text-sm font-medium transition-all">
                Search
            </button>
            @if(request('search'))
                <a href="{{ route('admin.orders.index') }}" class="text-gray-500 hover:text-gray-700 text-sm py-3">Clear</a>
            @endif
        </div>
    </form>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-4">Order</th>
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-4">Customer</th>
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-4">Items</th>
                        <th class="text-right text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-4">Total</th>
                        <th class="text-center text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-4">Status</th>
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-4">Date</th>
                        <th class="text-right text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-4">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-mono text-xs font-bold text-blue-600">{{ $order->order_number }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <span class="font-medium text-gray-800">{{ $order->shipping_name }}</span>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $order->shipping_phone }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $order->items_count ?? $order->items->count() }} item(s)</td>
                        <td class="px-6 py-4 text-right font-semibold text-gray-800">${{ number_format($order->total, 2) }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="status-badge status-{{ $order->status }}">
                                <span class="status-dot status-dot-{{ $order->status }}"></span>
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}"
                               class="text-xs font-bold border border-gray-200 hover:border-blue-500 hover:text-blue-500 px-4 py-2 rounded-xl transition-all inline-block">
                                View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <i class="fas fa-truck text-4xl text-gray-300"></i>
                                <p class="text-gray-500 font-medium">No orders yet</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $orders->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
