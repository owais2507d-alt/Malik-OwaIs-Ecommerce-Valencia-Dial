<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Valencia Console')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-sidebar: #000000;       /* Pitch Black Sidebar */
            --bg-canvas: #f8f9fa;        /* Clean Off-White Background */
            --bg-card: #ffffff;          /* Pure White Cards */
            --border-muted: #e5e7eb;      /* Soft Light Gray Borders for Content */
            --border-dark: #141414;       /* Dark Borders for Sidebar elements */
        }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-canvas); color: #000000; }
        .luxury-title { font-family: 'Playfair Display', serif; }
        .smooth-transition { transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1); }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg-canvas); }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 3px; }
    </style>
</head>
<body class="min-h-screen flex overflow-x-hidden antialiased">

    <!-- HIGH-CONTRAST PITCH BLACK SIDEBAR -->
    <aside class="w-64 fixed inset-y-0 left-0 hidden lg:flex flex-col justify-between p-6 border-r border-stone-900" style="background-color: var(--bg-sidebar);">
        <div class="space-y-8">
            <!-- Brand Head -->
            <div>
                <h3 class="luxury-title text-lg uppercase tracking-[0.35em] font-bold text-white">VALENCIA</h3>
                <p class="text-stone-500 text-[9px] tracking-[0.2em] uppercase mt-1 font-semibold">Management Portal</p>
            </div>

            <!-- Navigation Links -->
            <nav class="space-y-1">
                <!-- Dashboard Link -->
                <a href="{{ route('admin.dashboard') }}" class="smooth-transition flex items-center space-x-3 px-4 py-3 rounded-none text-xs uppercase tracking-widest font-medium text-stone-400 hover:text-white hover:bg-stone-900">
                    <svg class="w-4 h-4 stroke-[1.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/></svg>
                    <span>Dashboard</span>
                </a>
                
                <!-- Watch Vault Link (Active Monochrome Style) -->
                <a href="{{ route('admin.watches.index') }}" class="smooth-transition flex items-center space-x-3 px-4 py-3 text-xs uppercase tracking-widest font-bold text-black bg-white border border-white">
                    <svg class="w-4 h-4 stroke-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Watch Vault</span>
                </a>

                <!-- Quick Return to Site Link -->
                <a href="{{ route('shop.index') }}" class="smooth-transition flex items-center space-x-3 px-4 py-3 rounded-none text-xs uppercase tracking-widest font-medium text-stone-500 hover:text-stone-300">
                    <svg class="w-4 h-4 stroke-[1.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Public Atelier</span>
                </a>
            </nav>
        </div>

        <!-- Terminate Session Form -->
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="smooth-transition w-full text-left flex items-center space-x-3 px-4 py-3 text-stone-500 hover:text-red-400 text-xs uppercase tracking-widest font-medium cursor-pointer bg-transparent border-0">
                <svg class="w-4 h-4 stroke-[1.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span>Terminate Session</span>
            </button>
        </form>
    </aside>

    <!-- PREMIUM LIGHT CANVAS HUB -->
    <main class="flex-1 lg:pl-64 min-h-screen">
        <div class="p-6 md:p-10 max-w-6xl mx-auto space-y-8">
            @yield('content')
        </div>
    </main>

</body>
</html>