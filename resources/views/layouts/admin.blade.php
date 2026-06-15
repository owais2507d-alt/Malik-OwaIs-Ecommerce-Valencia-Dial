<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Valencia Corporate Admin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-body: #f4f7fe;         /* Fox Admin Light Gray Slate Background */
            --bg-sidebar: #1a233a;      /* Solid Deep Corporate Navy */
            --bg-topbar: #4e84ff;       /* Vibrant Tech Royal Blue Accent */
            --bg-card: #ffffff;         /* Crisp White Cards */
            --text-main: #2b3674;       /* Deep Indigo Primary Text */
            --text-secondary: #a3aed0;  /* Soft Dashboard Muted Text */
        }
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: var(--bg-body); 
            color: var(--text-main); 
        }
        .smooth-transition { transition: all 0.2s ease-in-out; }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased">

    <!-- TOP HEADER BAR -->
    <header class="h-16 fixed top-0 inset-x-0 z-40 flex items-center justify-between px-6 shadow-md" style="background-color: var(--bg-topbar);">
        <!-- Brand Title & Toggle -->
        <div class="flex items-center space-x-4">
            <div class="flex items-center space-x-2">
                <span class="text-white font-bold tracking-wider text-lg uppercase">Valencia Admin</span>
            </div>
            <button class="text-white/80 hover:text-white smooth-transition cursor-pointer">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>

        <!-- Top Right Utility Indicators -->
        <div class="flex items-center space-x-4 text-white">
            <button class="p-1.5 hover:bg-white/10 rounded-lg smooth-transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </button>
            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center font-bold text-xs">AD</div>
        </div>
    </header>

    <div class="flex flex-1 pt-16 min-h-screen">
        <!-- SIDEBAR PANEL -->
        <aside class="w-64 fixed inset-y-0 left-0 pt-16 hidden lg:flex flex-col justify-between p-4 shadow-xl" style="background-color: var(--bg-sidebar);">
            <div class="space-y-6 mt-4">
                <!-- User Profile Block -->
               <div class="flex items-center space-x-3 px-3 pb-4 border-b border-white/5">
    <div class="w-10 h-10 rounded-full bg-[#d4af37]/10 border border-[#d4af37]/20 flex items-center justify-center text-[#d4af37] font-bold text-sm uppercase">
        {{ strtoupper(substr(Auth::user()->name ?? 'V', 0, 1)) }}
    </div>
    
    <div>
        <p class="text-white text-xs font-semibold tracking-wide">
            {{ Auth::user()->name ?? 'Valencia Admin' }}
        </p>
        
        <span class="text-[10px] text-emerald-400 flex items-center space-x-1.5 mt-0.5 font-light">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block animate-pulse"></span>
            <span class="tracking-wider uppercase text-[9px]">Online</span>
        </span>
    </div>
</div>

                <!-- Navigation Hub -->
                <nav class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="smooth-transition flex items-center space-x-3 px-4 py-3 rounded-xl text-xs tracking-wide font-medium text-stone-400 hover:text-white hover:bg-white/5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/></svg>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="{{ route('admin.watches.index') }}" class="smooth-transition flex items-center space-x-3 px-4 py-3 rounded-xl text-xs tracking-wide font-semibold text-white bg-white/10 shadow-inner">
                        <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Watch Vault (CRUD)</span>
                    </a>

                    <a href="{{ route('shop.index') }}" target="_blank" class="smooth-transition flex items-center space-x-3 px-4 py-3 rounded-xl text-xs tracking-wide font-medium text-stone-400 hover:text-white hover:bg-white/5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span>Public Storefront</span>
                    </a>
                </nav>
            </div>

            <!-- Logout Command -->
            <form action="{{ route('logout') }}" method="POST" class="m-0 border-t border-white/5 pt-4">
                @csrf
                <button type="submit" class="smooth-transition w-full text-left flex items-center space-x-3 px-4 py-3 rounded-xl text-stone-400 hover:text-red-400 text-xs font-medium cursor-pointer bg-transparent border-0 hover:bg-red-500/5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span>Terminate Session</span>
                </button>
            </form>
        </aside>

        <!-- CONTENT AREA HUB -->
        <main class="flex-1 lg:pl-64 min-h-screen">
            <div class="p-6 md:p-8 max-w-7xl mx-auto space-y-6">
                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>