@extends('layouts.admin')

<title>Command Center | Valencia Admin</title>

@push('styles')
<style>
    * {
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .card {
        transition: all 0.2s ease;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .shadow-xs {
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    }
</style>
@endpush

@section('content')
<div class="bg-gray-50/80 antialiased">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 space-y-8">

        <!-- Header Section -->
        <div class="flex justify-between items-end">
            <div>
                <h1 class="text-3xl font-semibold text-gray-800">Command Center</h1>
                <p class="text-gray-600 mt-1">Welcome back, Master Admin 👋</p>
            </div>

            <a href="{{ route('admin.products.create') }}"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-sm font-semibold px-6 py-3 rounded-2xl shadow-xl shadow-blue-500/30 transition-all duration-200 active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Add Masterpiece</span>
            </a>
        </div>

        <!-- Stats Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="card bg-white border border-gray-100 rounded-3xl p-6 shadow-xs hover:shadow-md transition-all">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Products</p>
                <p class="text-3xl font-bold text-gray-900 mt-3">{{ $totalProducts }}</p>
                <p class="text-emerald-600 text-xs font-semibold mt-4 flex items-center gap-1">
                    <span class="bg-emerald-500/10 px-2 py-0.5 rounded-md">{{ $activeProducts }} Active</span> <span class="text-gray-400">in catalog</span>
                </p>
            </div>

            <div class="card bg-white border border-gray-100 rounded-3xl p-6 shadow-xs hover:shadow-md transition-all">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Categories</p>
                <p class="text-3xl font-bold text-gray-900 mt-3">{{ $totalCategories }}</p>
                <p class="text-amber-600 text-xs font-semibold mt-4">
                    <span class="bg-amber-500/10 px-2 py-0.5 rounded-md">Organized Collections</span>
                </p>
            </div>

            <div class="card bg-white border border-gray-100 rounded-3xl p-6 shadow-xs hover:shadow-md transition-all">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Stock</p>
                <p class="text-3xl font-bold text-gray-900 mt-3">{{ $totalStock }}</p>
                <p class="text-blue-600 text-xs font-semibold mt-4">
                    <span class="bg-blue-500/10 px-2 py-0.5 rounded-md">{{ $lowStock }} Low Stock Alerts</span>
                </p>
            </div>

            <div class="card bg-white border border-gray-100 rounded-3xl p-6 shadow-xs hover:shadow-md transition-all">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Customers</p>
                <p class="text-3xl font-bold text-gray-900 mt-3">{{ $totalUsers }}</p>
                <p class="text-gray-400 text-xs font-semibold mt-4">Registered clients</p>
            </div>

            <div class="card bg-white border border-gray-100 rounded-3xl p-6 shadow-xs hover:shadow-md transition-all">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Orders</p>
                <p class="text-3xl font-bold text-gray-900 mt-3">{{ $orderStats['total'] }}</p>
                <p class="text-amber-600 text-xs font-semibold mt-4 flex items-center gap-1">
                    <span class="bg-amber-500/10 px-2 py-0.5 rounded-md">{{ $orderStats['pending'] }} Pending</span>
                    <span class="text-gray-400">·</span>
                    <span class="bg-blue-500/10 px-2 py-0.5 rounded-md text-blue-600">{{ $orderStats['processing'] }} Processing</span>
                </p>
            </div>

            <div class="card bg-white border border-gray-100 rounded-3xl p-6 shadow-xs hover:shadow-md transition-all">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Revenue</p>
                <p class="text-3xl font-bold text-gray-900 mt-3">${{ number_format($orderStats['revenue'], 0) }}</p>
                <p class="text-emerald-600 text-xs font-semibold mt-4">
                    <span class="bg-emerald-500/10 px-2 py-0.5 rounded-md">{{ $orderStats['delivered'] }} Delivered</span>
                </p>
            </div>

            @php $mm = \App\Models\Setting::getValue('maintenance_mode', '0'); @endphp
            <a href="{{ route('admin.maintenance.index') }}" class="card bg-white border border-gray-100 rounded-3xl p-6 shadow-xs transition-all hover:shadow-md block {{ $mm === '1' ? 'ring-2 ring-red-300' : '' }}">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                    <i class="fas fa-shield-alt mr-1"></i> Maintenance
                </p>
                <div class="mt-3 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full {{ $mm === '1' ? 'bg-red-500' : 'bg-emerald-500' }}"></span>
                    <span class="text-xs font-semibold {{ $mm === '1' ? 'text-red-600' : 'text-emerald-600' }}">
                        {{ $mm === '1' ? 'Active — Site is down' : 'Inactive — Site is live' }}
                    </span>
                </div>
                <p class="text-[10px] text-gray-400 mt-3 tracking-wider uppercase font-medium">
                    <i class="fas fa-arrow-right mr-1"></i> Manage Settings
                </p>
            </a>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-7 gap-6">
            <div class="lg:col-span-4 card bg-white border border-gray-100 rounded-3xl p-6 shadow-xs">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-base font-bold text-gray-800">Revenue Trend • Last 6 Months</h2>
                    <span
                        class="text-[10px] uppercase font-bold tracking-wider px-2.5 py-1 bg-blue-500/10 text-blue-600 rounded-full">Live
                        Flow</span>
                </div>
                <div class="relative h-72">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <div class="lg:col-span-3 card bg-white border border-gray-100 rounded-3xl p-6 shadow-xs">
                <h2 class="text-base font-bold text-gray-800 mb-6">Collection Distribution</h2>
                <div class="relative h-72">
                    <canvas id="collectionChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Orders Table -->
        <div class="card bg-white border border-gray-100 rounded-3xl p-6 shadow-xs">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-base font-bold text-gray-800">Recent Orders</h2>
                <a href="{{ route('admin.orders.index') }}"
                    class="text-blue-600 hover:text-blue-700 text-sm font-semibold flex items-center gap-1 transition-all">View
                    All <span>→</span></a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr
                            class="border-b border-gray-100 text-[11px] font-bold uppercase tracking-wider text-gray-400">
                            <th class="pb-4">Reference</th>
                            <th class="pb-4">Client</th>
                            <th class="pb-4">City</th>
                            <th class="pb-4 text-right">Value</th>
                            <th class="pb-4 text-center">Status</th>
                            <th class="pb-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-gray-700 font-medium">
                        @forelse($recentOrders as $order)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-4 font-mono text-xs text-blue-600 font-bold">{{ $order->order_number }}</td>
                            <td class="py-4 text-gray-900">{{ $order->shipping_name }}</td>
                            <td class="py-4 text-gray-500">{{ $order->shipping_city }}</td>
                            <td class="py-4 text-right font-bold text-gray-900 font-mono">${{ number_format($order->total, 2) }}</td>
                            <td class="py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 text-[11px] font-bold rounded-full
                                    @switch($order->status)
                                        @case('pending') bg-amber-50 text-amber-700 @break
                                        @case('confirmed') bg-blue-50 text-blue-700 @break
                                        @case('processing') bg-indigo-50 text-indigo-700 @break
                                        @case('shipped') bg-blue-50 text-blue-700 @break
                                        @case('delivered') bg-emerald-50 text-emerald-700 @break
                                        @case('cancelled') bg-red-50 text-red-700 @break
                                    @endswitch
                                ">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="py-4 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}"
                                    class="text-xs font-bold border border-gray-200 hover:border-blue-500 hover:text-blue-500 px-4 py-2 rounded-xl transition-all inline-block">
                                    VIEW
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-400">No orders yet</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // --- REVENUE TREND ---
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            const blueGradient = revenueCtx.createLinearGradient(0, 0, 0, 250);
            blueGradient.addColorStop(0, 'rgba(59, 130, 246, 0.25)');
            blueGradient.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

            const revenueData = @json($revenueData);

            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: @json($monthLabels),
                    datasets: [{
                        label: 'Revenue',
                        data: revenueData,
                        borderColor: '#2563eb',
                        backgroundColor: blueGradient,
                        fill: true,
                        tension: 0.38,
                        borderWidth: 3,
                        pointBackgroundColor: '#2563eb',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            grid: { color: 'rgba(0, 0, 0, 0.03)', borderDash: [5, 5] },
                            ticks: {
                                color: '#94a3b8',
                                font: { size: 11 },
                                callback: function (value) {
                                    return '$' + (value / 1000000).toFixed(1) + 'M';
                                }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: {
                                color: '#94a3b8',
                                font: { size: 11, weight: '500' }
                            }
                        }
                    }
                }
            });

            // --- COLLECTION DISTRIBUTION ---
            new Chart(document.getElementById('collectionChart'), {
                type: 'doughnut',
                data: {
                    labels: @json($categoryLabels),
                    datasets: [{
                        data: @json($categoryData),
                        backgroundColor: @json($categoryColors),
                        borderColor: '#ffffff',
                        borderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#64748b',
                                padding: 16,
                                font: { size: 11, weight: '600' },
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
