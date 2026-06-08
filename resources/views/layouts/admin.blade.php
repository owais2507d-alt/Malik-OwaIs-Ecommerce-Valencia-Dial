<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Valencia Admin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght=500;700&family=Inter:wght=300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-canvas: #08080a;
            --bg-card: #0d0d11;
            --bg-input: #121217;
            --border-muted: #1c1c24;
            --text-gold: #d4af37;
            --text-gold-hover: #bfa030;
        }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-canvas); color: #e4e4e7; }
        .luxury-title { font-family: 'Playfair Display', serif; }
        .smooth-transition { transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1); }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg-canvas); }
        ::-webkit-scrollbar-thumb { background: var(--border-muted); border-radius: 3px; }
    </style>
</head>
<body class="min-h-screen flex overflow-x-hidden">

    <!-- SHARED LUXURY SIDEBAR -->
    <aside class="w-64 fixed inset-y-0 left-0 hidden lg:flex flex-col justify-between p-6 border-r" style="background-color: var(--bg-card); border-color: var(--border-muted);">
        <div class="space-y-8">
            <div>
                <h3 class="luxury-title text-lg uppercase tracking-[0.35em] font-bold" style="color: var(--text-gold);">VALENCIA</h3>
                <p class="text-stone-600 text-[9px] tracking-[0.2em] uppercase mt-1">Management Portal</p>
            </div>

            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="smooth-transition flex items-center space-x-3 px-4 py-3 text-stone-400 hover:text-white text-xs uppercase tracking-widest font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/></svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.watches.index') }}" class="smooth-transition flex items-center space-x-3 px-4 py-3 text-xs uppercase tracking-widest font-semibold border-l-2 text-white bg-[#121217]" style="border-color: var(--text-gold);">
                    <svg class="w-4 h-4" style="color: var(--text-gold);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span style="color: var(--text-gold);">Watch Vault</span>
                </a>
            </nav>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="smooth-transition w-full text-left flex items-center space-x-3 px-4 py-3 text-stone-500 hover:text-red-400 text-xs uppercase tracking-widest font-medium cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span>Terminate Session</span>
            </button>
        </form>
    </aside>

    <!-- MAIN CONTENT HUB (Jahan baki pages load honge) -->
    <main class="flex-1 lg:pl-64 min-h-screen">
        <div class="p-6 md:p-10 max-w-6xl mx-auto space-y-8">
            @yield('content')
        </div>
    </main>

</body>
</html>