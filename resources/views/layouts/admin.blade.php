<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Valencia Admin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    @stack('styles')

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .sidebar {
            background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 100%);
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.15);
            transition: transform 0.4s ease-in-out;
        }
        .nav-link {
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            background-color: rgba(255,255,255,0.15);
            transform: translateX(6px);
        }
        .nav-link.active {
            background-color: rgba(255,255,255,0.2);
            border-left: 5px solid #60a5fa;
            font-weight: 600;
        }
        .topbar {
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .main-content {
            background: #f8fafc;
        }
    </style>
</head>
<body class="min-h-screen">

    <div class="flex h-screen overflow-hidden">

        <!-- SIDEBAR -->
        <aside id="sidebar" class="sidebar w-72 text-white flex flex-col fixed lg:relative h-full z-50 -translate-x-full lg:translate-x-0">
            
            <!-- Logo -->
            <div class="px-6 py-6 border-b border-white/20 flex items-center gap-3">
                <div class="w-11 h-11 bg-white rounded-2xl flex items-center justify-center text-blue-600 font-bold text-3xl shadow-inner">
                    V
                </div>
                <div>
                    <span class="text-3xl font-bold tracking-tighter">Valencia</span>
                    <span class="block text-sm text-blue-200 -mt-1 tracking-widest">ADMIN PANEL</span>
                </div>
            </div>

            <!-- Navigation -->
            <div class="flex-1 overflow-y-auto py-8 px-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="nav-link flex items-center gap-3 px-6 py-4 rounded-2xl text-white text-[15px] {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home w-5"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.categories.index') }}" class="nav-link flex items-center gap-3 px-6 py-4 rounded-2xl text-white text-[15px] {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-tags w-5"></i>
                    <span>Categories</span>
                </a>
                <a href="{{ route('admin.products.index') }}" class="nav-link flex items-center gap-3 px-6 py-4 rounded-2xl text-white text-[15px] {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fas fa-box w-5"></i>
                    <span>Products</span>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="nav-link flex items-center gap-3 px-6 py-4 rounded-2xl text-white text-[15px] {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-bag w-5"></i>
                    <span>Orders</span>
                </a>
                <a href="{{ route('admin.hero-settings.index') }}" class="nav-link flex items-center gap-3 px-6 py-4 rounded-2xl text-white text-[15px] {{ request()->routeIs('admin.hero-settings.*') ? 'active' : '' }}">
                    <i class="fas fa-image w-5"></i>
                    <span>Hero Settings</span>
                </a>
                <a href="{{ route('admin.maintenance.index') }}" class="nav-link flex items-center gap-3 px-6 py-4 rounded-2xl text-white text-[15px] {{ request()->routeIs('admin.maintenance.*') ? 'active' : '' }}">
                    <i class="fas fa-shield-alt w-5"></i>
                    <span>Maintenance</span>
                </a>
            </div>

            <!-- Logout -->
            <div class="p-5 border-t border-white/20">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-3 bg-red-500/10 hover:bg-red-500/20 text-red-300 hover:text-red-200 py-4 rounded-2xl transition-all">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN AREA -->
        <div class="flex-1 flex flex-col">

            <!-- TOPBAR -->
            <header class="topbar h-16 flex items-center justify-between px-8">
                <div class="flex items-center gap-4">
                    <button id="sidebarToggle" class="lg:hidden text-3xl text-gray-600 hover:text-gray-800">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="text-2xl font-semibold text-gray-800">@yield('title', 'Dashboard')</h1>
                </div>

                <div class="flex items-center gap-6">
                    <div class="hidden md:block">
                        <p class="text-gray-600">Hi, <span class="font-semibold text-gray-800">{{ Auth::user()->name ?? 'Admin' }}</span> 👋</p>
                    </div>

                    <form action="{{ route('admin.search') }}" method="GET" class="relative w-80">
                        <input type="text" name="q" placeholder="Search products, orders..." 
                               value="{{ request('q') }}"
                               class="w-full bg-gray-100 border border-gray-300 rounded-3xl py-3 pl-12 pr-5 focus:outline-none focus:border-blue-400"
                               onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#d1d5db'">
                        <i class="fas fa-search absolute left-5 top-3.5 text-gray-400"></i>
                    </form>

                    @php
                        $lowStockCount = \App\Models\Product::where('stock', '>', 0)->where('stock', '<=', 5)->count();
                        $pendingOrdersCount = \App\Models\Order::where('status', 'pending')->count();
                        $notificationCount = $lowStockCount + $pendingOrdersCount;
                    @endphp
                    <div class="relative group">
                        <button class="relative text-gray-600 hover:text-blue-600 transition-colors" onclick="toggleNotifications()">
                            <i class="fas fa-bell text-2xl"></i>
                            @if($notificationCount > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] w-5 h-5 rounded-full flex items-center justify-center font-bold">{{ $notificationCount > 9 ? '9+' : $notificationCount }}</span>
                            @endif
                        </button>
                        <div id="notificationDropdown" class="hidden absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50">
                            <div class="p-4 border-b border-gray-100">
                                <h3 class="font-bold text-gray-800 text-sm">Notifications</h3>
                            </div>
                            <div class="max-h-72 overflow-y-auto divide-y divide-gray-50">
                                @if($lowStockCount > 0)
                                    <a href="{{ route('admin.products.index') }}" class="flex items-start gap-3 p-4 hover:bg-amber-50/50 transition-colors">
                                        <div class="w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center shrink-0">
                                            <i class="fas fa-exclamation-triangle text-amber-600 text-xs"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800">Low Stock Alert</p>
                                            <p class="text-xs text-gray-500">{{ $lowStockCount }} product(s) running low on stock</p>
                                        </div>
                                    </a>
                                @endif
                                @if($pendingOrdersCount > 0)
                                    <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="flex items-start gap-3 p-4 hover:bg-blue-50/50 transition-colors">
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center shrink-0">
                                            <i class="fas fa-clock text-blue-600 text-xs"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800">Pending Orders</p>
                                            <p class="text-xs text-gray-500">{{ $pendingOrdersCount }} order(s) awaiting confirmation</p>
                                        </div>
                                    </a>
                                @endif
                                @if($notificationCount === 0)
                                    <div class="p-6 text-center text-gray-400 text-sm">
                                        <i class="fas fa-check-circle text-emerald-400 text-2xl mb-2"></i>
                                        <p>All clear — no alerts</p>
                                    </div>
                                @endif
                            </div>
                            @if($notificationCount > 0)
                                <div class="p-3 border-t border-gray-100 text-center">
                                    <span class="text-xs font-semibold text-blue-600">{{ $notificationCount }} notification(s)</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=3b82f6&color=fff" 
                             class="w-10 h-10 rounded-2xl" alt="Profile">
                        <div>
                            <p class="font-semibold text-gray-800 text-sm">{{ Auth::user()->name ?? 'Administrator' }}</p>
                            <p class="text-xs text-gray-500 -mt-0.5">Admin</p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- CONTENT -->
            <main class="main-content flex-1 overflow-auto p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Mobile Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebarToggle');

        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });
        }

        // Notification Dropdown Toggle
        function toggleNotifications() {
            const dropdown = document.getElementById('notificationDropdown');
            if (dropdown) {
                dropdown.classList.toggle('hidden');
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('notificationDropdown');
            const bellBtn = document.querySelector('.group');
            if (dropdown && bellBtn && !bellBtn.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>