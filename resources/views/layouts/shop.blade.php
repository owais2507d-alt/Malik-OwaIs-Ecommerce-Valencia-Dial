<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Valencia Dial | Haute Horology Atelier')</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts for Ultra-Luxury Look -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300&family=Montserrat:wght@200;300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #040405;
        }
        .luxury-title {
            font-family: 'Cormorant Garamond', serif;
        }
        .smooth-transition {
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
    </style>
</head>
<body class="text-stone-300 antialiased min-h-screen flex flex-col justify-between">

    <!-- Global Premium Header / Navigation -->
    <header class="sticky top-0 z-50 bg-[#040405]/80 backdrop-blur-md border-b border-stone-900/60 px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="luxury-title text-2xl tracking-[0.25em] text-white font-light smooth-transition hover:text-[#d4af37]">
                VALENCIA <span class="font-normal text-[#d4af37]">DIAL</span>
            </a>

            <!-- Upgraded Master Navbar Links -->
            <nav class="hidden md:flex items-center space-x-10 text-[10px] uppercase tracking-[0.3em] font-medium text-stone-400">
                <a href="{{ route('shop.index') }}" class="text-white hover:text-[#d4af37] smooth-transition">Atelier Vault</a>
                <a href="#" class="hover:text-white smooth-transition">Patek Philippe</a>
                <a href="#" class="hover:text-white smooth-transition">Audemars Piguet</a>
                <a href="#" class="hover:text-white smooth-transition">Rolex</a>
                <a href="#" class="hover:text-white smooth-transition">Bespoke Curation</a>
            </nav>

            <!-- User Status / Cart Icons -->
            <div class="flex items-center space-x-6 text-[10px] uppercase tracking-[0.2em]">
                @auth
                    <span class="text-stone-400 font-light">Welcome, <span class="text-[#d4af37]">{{ Auth::user()->name }}</span></span>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-stone-500 hover:text-white smooth-transition">
                        Exit
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                @else
                    <a href="{{ route('login') }}" class="text-stone-400 hover:text-white smooth-transition">Portal</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Master Layout Global Hero Section -->
    <section class="relative min-h-[65vh] flex flex-col items-center justify-center text-center px-4 overflow-hidden border-b border-stone-900/60 bg-gradient from-[#0e0e12] via-[#07070a] to-[#040405] py-28">
        <!-- Golden Ambient Light Effect -->
        <div class="absolute w-600px h-350px bg-[#d4af37]/5 blur-[150px] rounded-full top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>

        <div class="relative z-10 space-y-8 max-w-4xl">
            <!-- Timeline Heritage Badge -->
            <div class="flex items-center justify-center space-x-4">
                <span class="h-1px w-12 bg-[#d4af37]/30"></span>
                <span class="text-[11px] uppercase tracking-[0.6em] text-[#d4af37] font-semibold">ESTABLISHED 2026</span>
                <span class="h-1px w-12 bg-[#d4af37]/30"></span>
            </div>
            
            <!-- Scaled-Up Hero Headline -->
            <h1 class="luxury-title text-6xl md:text-7xl font-light tracking-[0.18em] text-white uppercase leading-tight">
                The Elite <span class="font-normal text-[#d4af37]">Vault</span>
            </h1>
            
            <!-- Explanatory Narrative -->
            <p class="text-stone-400 text-sm md:text-base max-w-2xl mx-auto font-light leading-relaxed tracking-wider">
                Step into our bespoke sanctuary. Every time-piece inside this digital vault is a mechanical masterpiece, curated for those who command time rather than follow it.
            </p>

            <!-- Authentication Controls inside Hero -->
            @guest
                <div class="pt-6 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('login') }}" class="w-full sm:w-auto min-w-180px text-[10px] uppercase tracking-[0.3em] font-bold py-4 px-6 bg-[#d4af37] text-black border border-[#d4af37] smooth-transition hover:bg-transparent hover:text-[#d4af37]">
                        Initialize Access
                    </a>
                    <a href="{{ route('register') }}" class="w-full sm:w-auto min-w-180px text-[10px] uppercase tracking-[0.3em] font-bold py-4 px-6 bg-transparent text-stone-300 border border-stone-800 smooth-transition hover:border-white hover:text-white">
                        Create Dossier
                    </a>
                </div>
            @endguest
        </div>
    </section>

    <!-- Dynamic Content Pipeline (Aapka baki pages ka maal yahan fit hoga) -->
    <main class="flex-row">
        @yield('content')
    </main>

    <!-- Global Premium Footer -->
    <footer class="bg-[#020203] border-t border-stone-900/80 py-12 px-6 text-center text-stone-600 text-[10px] uppercase tracking-[0.25em]">
        <div class="max-w-7xl mx-auto space-y-4">
            <p class="text-stone-500 luxury-title text-base tracking-[0.2em] lowercase italic">crafted for connoisseurs of horizontal mechanics.</p>
            <p>&copy; 2026 Valencia Dial Atelier. All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>