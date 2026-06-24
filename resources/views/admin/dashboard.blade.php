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

            <a href="#"
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
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Vault Value</p>
                <p class="text-3xl font-bold text-gray-900 mt-3">$2,487,500.00</p>
                <p class="text-emerald-600 text-xs font-semibold mt-4 flex items-center gap-1">
                    <span class="bg-emerald-500/10 px-2 py-0.5 rounded-md">↑ 18.4%</span> <span class="text-gray-400">vs
                        last month</span>
                </p>
            </div>

            <div class="card bg-white border border-gray-100 rounded-3xl p-6 shadow-xs hover:shadow-md transition-all">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Active Allocations</p>
                <p class="text-3xl font-bold text-gray-900 mt-3">47</p>
                <p class="text-amber-600 text-xs font-semibold mt-4">
                    <span class="bg-amber-500/10 px-2 py-0.5 rounded-md">12 Pending Approval</span>
                </p>
            </div>

            <div class="card bg-white border border-gray-100 rounded-3xl p-6 shadow-xs hover:shadow-md transition-all">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Watches in Vault</p>
                <p class="text-3xl font-bold text-gray-900 mt-3">184</p>
                <p class="text-blue-600 text-xs font-semibold mt-4">
                    <span class="bg-blue-500/10 px-2 py-0.5 rounded-md">• Synchronized Stream</span>
                </p>
            </div>

            <div class="card bg-white border border-gray-100 rounded-3xl p-6 shadow-xs hover:shadow-md transition-all">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Avg. Dispatch Time</p>
                <p class="text-3xl font-bold text-gray-900 mt-3">9.4 <span
                        class="text-xl font-normal text-gray-400">days</span></p>
                <p class="text-gray-400 text-xs font-semibold mt-4">Automated fulfillment sync</p>
            </div>
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

        <!-- Recent Pipeline Activity Table -->
        <div class="card bg-white border border-gray-100 rounded-3xl p-6 shadow-xs">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-base font-bold text-gray-800">Recent Pipeline Activity</h2>
                <a href="#"
                    class="text-blue-600 hover:text-blue-700 text-sm font-semibold flex items-center gap-1 transition-all">View
                    Full Log <span>→</span></a>
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
                        <!-- Order 1 -->
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-4 font-mono text-xs text-blue-600 font-bold">#VAL-00124</td>
                            <td class="py-4 text-gray-900">Alexander Hamilton</td>
                            <td class="py-4 text-gray-500">New York</td>
                            <td class="py-4 text-right font-bold text-gray-900 font-mono">$12,450.00</td>
                            <td class="py-4 text-center">
                                <span
                                    class="inline-flex items-center px-3 py-1 text-[11px] font-bold rounded-full bg-emerald-50 text-emerald-700">
                                    Delivered
                                </span>
                            </td>
                            <td class="py-4 text-right">
                                <a href="#"
                                    class="text-xs font-bold border border-gray-200 hover:border-blue-500 hover:text-blue-500 px-4 py-2 rounded-xl transition-all inline-block">
                                    OPEN DOSSIER
                                </a>
                            </td>
                        </tr>

                        <!-- Order 2 -->
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-4 font-mono text-xs text-blue-600 font-bold">#VAL-00123</td>
                            <td class="py-4 text-gray-900">Victoria Chen</td>
                            <td class="py-4 text-gray-500">Singapore</td>
                            <td class="py-4 text-right font-bold text-gray-900 font-mono">$34,500.00</td>
                            <td class="py-4 text-center">
                                <span
                                    class="inline-flex items-center px-3 py-1 text-[11px] font-bold rounded-full bg-amber-50 text-amber-700">
                                    Pending
                                </span>
                            </td>
                            <td class="py-4 text-right">
                                <a href="#"
                                    class="text-xs font-bold border border-gray-200 hover:border-blue-500 hover:text-blue-500 px-4 py-2 rounded-xl transition-all inline-block">
                                    OPEN DOSSIER
                                </a>
                            </td>
                        </tr>

                        <!-- Order 3 -->
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-4 font-mono text-xs text-blue-600 font-bold">#VAL-00122</td>
                            <td class="py-4 text-gray-900">Marcus Aurelius</td>
                            <td class="py-4 text-gray-500">Rome</td>
                            <td class="py-4 text-right font-bold text-gray-900 font-mono">$42,800.00</td>
                            <td class="py-4 text-center">
                                <span
                                    class="inline-flex items-center px-3 py-1 text-[11px] font-bold rounded-full bg-amber-50 text-amber-700">
                                    Processing
                                </span>
                            </td>
                            <td class="py-4 text-right">
                                <a href="#"
                                    class="text-xs font-bold border border-gray-200 hover:border-blue-500 hover:text-blue-500 px-4 py-2 rounded-xl transition-all inline-block">
                                    OPEN DOSSIER
                                </a>
                            </td>
                        </tr>

                        <!-- Order 4 -->
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-4 font-mono text-xs text-blue-600 font-bold">#VAL-00121</td>
                            <td class="py-4 text-gray-900">Isabella Rossi</td>
                            <td class="py-4 text-gray-500">Milan</td>
                            <td class="py-4 text-right font-bold text-gray-900 font-mono">$8,750.00</td>
                            <td class="py-4 text-center">
                                <span
                                    class="inline-flex items-center px-3 py-1 text-[11px] font-bold rounded-full bg-emerald-50 text-emerald-700">
                                    Delivered
                                </span>
                            </td>
                            <td class="py-4 text-right">
                                <a href="#"
                                    class="text-xs font-bold border border-gray-200 hover:border-blue-500 hover:text-blue-500 px-4 py-2 rounded-xl transition-all inline-block">
                                    OPEN DOSSIER
                                </a>
                            </td>
                        </tr>

                        <!-- Order 5 -->
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-4 font-mono text-xs text-blue-600 font-bold">#VAL-00120</td>
                            <td class="py-4 text-gray-900">James Donovan</td>
                            <td class="py-4 text-gray-500">London</td>
                            <td class="py-4 text-right font-bold text-gray-900 font-mono">$9,200.00</td>
                            <td class="py-4 text-center">
                                <span
                                    class="inline-flex items-center px-3 py-1 text-[11px] font-bold rounded-full bg-amber-50 text-amber-700">
                                    Pending
                                </span>
                            </td>
                            <td class="py-4 text-right">
                                <a href="#"
                                    class="text-xs font-bold border border-gray-200 hover:border-blue-500 hover:text-blue-500 px-4 py-2 rounded-xl transition-all inline-block">
                                    OPEN DOSSIER
                                </a>
                            </td>
                        </tr>
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

            // Sample revenue data (matching the dynamic data from the original)
            const revenueData = [1240000, 1580000, 1390000, 1920000, 2210000, 2480000];

            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
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
                    labels: ['Nautilus', 'Daytona', 'Submariner', 'Royal Oak', 'Others'],
                    datasets: [{
                        data: [42, 28, 35, 51, 28],
                        backgroundColor: ['#2563eb', '#4f46e5', '#6366f1', '#818cf8', '#94a3b8'],
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
