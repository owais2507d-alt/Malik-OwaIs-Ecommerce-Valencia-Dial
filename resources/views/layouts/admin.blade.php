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
                <a href="{{ route('admin.dashboard') }}" class="nav-link active flex items-center gap-3 px-6 py-4 rounded-2xl text-white text-[15px]">
                    <i class="fas fa-home w-5"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.categories.index') }}" class="nav-link flex items-center gap-3 px-6 py-4 rounded-2xl text-white text-[15px]">
                    <i class="fas fa-watch w-5"></i>
                    <span>Categories</span>
                </a>
                {{-- <a href="" class="nav-link flex items-center gap-3 px-6 py-4 rounded-2xl text-white text-[15px]">
                    <i class="fas fa-shopping-bag w-5"></i>
                    <span>Orders</span>
                </a>
                <a href="#" class="nav-link flex items-center gap-3 px-6 py-4 rounded-2xl text-white text-[15px]">
                    <i class="fas fa-users w-5"></i>
                    <span>Customers</span>
                </a>
                <a href="#" class="nav-link flex items-center gap-3 px-6 py-4 rounded-2xl text-white text-[15px]">
                    <i class="fas fa-chart-bar w-5"></i>
                    <span>Reports</span>
                </a> --}}
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

                    <div class="relative w-80">
                        <input type="text" placeholder="Search anything..." 
                               class="w-full bg-gray-100 border border-gray-300 rounded-3xl py-3 pl-12 pr-5 focus:outline-none focus:border-blue-400">
                        <i class="fas fa-search absolute left-5 top-3.5 text-gray-400"></i>
                    </div>

                    <button class="relative text-gray-600 hover:text-blue-600 transition-colors">
                        <i class="fas fa-bell text-2xl"></i>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] w-5 h-5 rounded-full flex items-center justify-center">3</span>
                    </button>

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
    </script>
    @stack('scripts')
</body>
</html>