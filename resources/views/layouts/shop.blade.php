<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Valencia Dial | Haute Horology Atelier')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght=0,300;0,400;0,500;1,300&family=Montserrat:wght@100;200;300;400;500;600&display=swap" rel="stylesheet">
     
    <style>
        /* CENTRALIZED PREMIUM COLOR PALETTE (IMAGE LOGO GOLD PROFILE) */
        :root {
            --color-bg-main: #040405;
            --color-dark-gold: #e5c158; /* Premium Vibrant Gold from image */
            --color-dark-gold-dim: rgba(229, 193, 88, 0.15);
            --color-gold-bright: #fff2a3; /* High-glow highlight profile */
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--color-bg-main);
        }
        .luxury-title {
            font-family: 'Cormorant Garamond', serif;
        }
        .smooth-transition {
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        /* CSS Root Helpers */
        .text-dark-gold { color: var(--color-dark-gold); }
        .bg-dark-gold { background-color: var(--color-dark-gold); }
        .border-dark-gold { border-color: var(--color-dark-gold); }
        .border-dark-gold-dim { border-color: var(--color-dark-gold-dim); }
        
        .hover-gold-glow:hover {
            color: var(--color-dark-gold);
            text-shadow: 0 0 12px rgba(229, 193, 88, 0.5);
        }
    </style>
</head>
<body class="text-stone-400 antialiased min-h-screen flex flex-col justify-between" x-data="{ mobileMenuOpen: false }">

    <header class="sticky top-0 z-50 bg-[#040405]/90 backdrop-blur-xl border-b border-stone-900/60 px-4 sm:px-6 lg:px-12 py-5 sm:py-6">
        <div class="max-w-1600px mx-auto flex items-center justify-between">
            
            <div class="flex-shrink-0">
                <a href="{{ url('/') }}" class="luxury-title block text-xl sm:text-2xl tracking-[0.25em] text-stone-200 font-light smooth-transition hover:opacity-80 uppercase leading-none">
                    VALENCIA 
                    <span class="block text-[9px] sm:text-[10px] tracking-[0.45em] text-dark-gold font-semibold mt-1.5">DIAL</span>
                </a>
            </div>

            <nav class="hidden lg:flex items-center space-x-10 xl:space-x-14 text-[10px] uppercase tracking-[0.35em] font-medium">
                <a href="{{ url('/') }}" class="text-stone-200 hover-gold-glow smooth-transition">Home</a>
                <a href="{{ route('shop.index') }}" class="text-stone-400 hover-gold-glow smooth-transition">Products</a>
                <a href="#" class="text-stone-400 hover-gold-glow smooth-transition">About</a>
                <a href="#" class="text-stone-400 hover-gold-glow smooth-transition">Contact</a>
            </nav>

            <div class="hidden lg:flex items-center space-x-8 text-[10px] uppercase tracking-[0.25em] font-light">
                <a href="#" class="text-stone-300 hover:text-white smooth-transition flex items-center space-x-2 group">
                    <span class="tracking-[0.3em] group-hover:text-dark-gold smooth-transition">CART</span>
                    <span class="text-dark-gold group-hover:text-stone-200 smooth-transition font-normal">({{ count((array) session('cart')) }})</span>
                </a>
                
                <span class="text-stone-800">|</span>

                @auth
                    <div class="flex items-center space-x-6">
                        <span class="text-stone-400">Vault: <span class="text-dark-gold font-medium tracking-wider">{{ Auth::user()->name }}</span></span>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-stone-500 hover:text-red-400 smooth-transition font-medium tracking-widest">
                            Exit
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                    </div>
                @else
                    <div class="flex items-center space-x-4 font-medium">
                        <a href="{{ route('login') }}" class="text-stone-400 hover:text-stone-100 smooth-transition">Login</a>
                        <span class="text-stone-800">/</span>
                        <a href="{{ route('register') }}" class="text-stone-400 hover:text-stone-100 smooth-transition">Register</a>
                    </div>
                @endauth
            </div>

            <div class="flex items-center lg:hidden space-x-5">
                <a href="#" class="text-[10px] tracking-[0.2em] text-stone-300 font-medium">
                    CART <span class="text-dark-gold">(0)</span>
                </a>
                
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-stone-300 focus:outline-none p-1 cursor-pointer z-50">
                    <svg class="w-6 h-6 smooth-transition" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24" x-show="!mobileMenuOpen">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5"/>
                    </svg>
                    <svg class="w-6 h-6 smooth-transition" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24" x-show="mobileMenuOpen" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <div class="lg:hidden fixed inset-x-0 top-[73px] h-screen bg-[#040405]/98 backdrop-blur-2xl border-t border-stone-900/60 z-40 transition-all duration-300" 
             x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             style="display: none;">
            <div class="flex flex-col space-y-6 text-center tracking-[0.3em] text-[11px] uppercase pt-12 px-6">
                <a href="{{ url('/') }}" @click="mobileMenuOpen = false" class="text-stone-200 py-2 border-b border-stone-900/40 hover:text-white">Home</a>
                <a href="{{ route('shop.index') }}" @click="mobileMenuOpen = false" class="text-stone-400 py-2 border-b border-stone-900/40 hover:text-white">Products</a>
                <a href="#" @click="mobileMenuOpen = false" class="text-stone-400 py-2 border-b border-stone-900/40 hover:text-white">About</a>
                <a href="#" @click="mobileMenuOpen = false" class="text-stone-400 py-2 border-b border-stone-900/40 hover:text-white">Contact</a>
                
                <div class="pt-6">
                    @auth
                        <p class="text-stone-500 text-[10px] mb-3 normal-case tracking-wide">Logged in as: <span class="text-dark-gold font-medium">{{ Auth::user()->name }}</span></p>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();" class="text-red-900/80 font-medium block py-2 tracking-widest text-[10px] border border-red-950/40 bg-red-950/10">Exit Vault</a>
                        <form id="mobile-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                    @else
                        <div class="grid grid-cols-2 gap-4 pt-4">
                            <a href="{{ route('login') }}" class="text-stone-300 py-3 border border-stone-800 text-[10px] tracking-[0.25em]">Login</a>
                            <a href="{{ route('register') }}" class="text-black py-3 text-[10px] tracking-[0.25em] font-medium transition-opacity hover:opacity-95" style="background-color: var(--color-dark-gold);">Register</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <section class="relative min-h-[60vh] sm:min-h-[65vh] flex flex-col items-center justify-center text-center px-4 overflow-hidden border-b border-stone-900/40 bg-gradient-to-b from-[#0a0a0d] via-[#050507] to-[#040405] py-24 sm:py-32">
        
        <div class="absolute w-[300px] sm:w-[600px] h-[200px] sm:h-[350px] opacity-[0.18] blur-[100px] sm:blur-[160px] rounded-full top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 pointer-events-none" style="background-color: var(--color-dark-gold);"></div>

        <div class="relative z-10 space-y-6 sm:space-y-8 max-w-4xl px-2">
            <div class="flex items-center justify-center space-x-3 sm:space-x-4">
                <span class="h-[1px] w-8 sm:w-12 bg-gradient-to-r from-transparent to-[#e5c158] opacity-60"></span>
                <span class="text-[9px] sm:text-[11px] uppercase tracking-[0.5em] text-dark-gold font-medium">ESTABLISHED 2026</span>
                <span class="h-[1px] w-8 sm:w-12 bg-gradient-to-l from-transparent to-[#e5c158] opacity-60"></span>
            </div>
            
            <h1 class="luxury-title text-4xl sm:text-6xl md:text-7xl lg:text-8xl font-light tracking-[0.15em] text-stone-200 uppercase leading-tight">
                The Elite <span class="font-normal text-dark-gold">Vault</span>
            </h1>
            
            <p class="text-stone-500 text-xs sm:text-sm max-w-xl sm:max-w-2xl mx-auto font-light leading-[2] tracking-widest px-2">
                Step into our bespoke sanctuary. Every timepiece inside this digital vault is a mechanical masterpiece, curated for those who command time rather than follow it.
            </p>

            @guest
                <div class="pt-6 flex flex-col sm:flex-row items-center justify-center gap-4 max-w-xs sm:max-w-none mx-auto w-full px-4 sm:px-0">
                    <a href="{{ route('login') }}" class="w-full sm:w-auto min-w-[190px] text-[10px] uppercase tracking-[0.3em] py-4 px-6 bg-transparent text-stone-200 border border-stone-800 smooth-transition hover:border-dark-gold hover:text-dark-gold text-center font-medium">
                        Initialize Access
                    </a>
                    <a href="{{ route('register') }}" class="w-full sm:w-auto min-w-[190px] text-[10px] uppercase tracking-[0.3em] font-medium py-4 px-6 text-black smooth-transition hover:opacity-90 text-center shadow-lg shadow-black/50" style="background-color: var(--color-dark-gold);">
                        Create Dossier
                    </a>
                </div>
            @endguest
        </div>
    </section>

    <main class="w-full flex-grow bg-[#040405]">
        @yield('content')
    </main>

    <footer class="bg-[#020203] border-t border-stone-900/60 pt-16 pb-12 px-6 text-stone-600 text-[10px] uppercase tracking-[0.25em]">
        <div class="max-w-[1400px] mx-auto space-y-12">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-10 text-left border-b border-stone-950 pb-12">
                <div class="space-y-4">
                    <h4 class="text-stone-400 font-medium tracking-[0.3em] text-[11px]">Navigation</h4>
                    <ul class="space-y-2.5 text-stone-500 lowercase tracking-normal text-xs font-light">
                        <li><a href="{{ url('/') }}" class="hover:text-dark-gold smooth-transition">Home</a></li>
                        <li><a href="{{ route('shop.index') }}" class="hover:text-dark-gold smooth-transition">Products Catalogue</a></li>
                    </ul>
                </div>
                <div class="space-y-4">
                    <h4 class="text-stone-400 font-medium tracking-[0.3em] text-[11px]">Atelier</h4>
                    <ul class="space-y-2.5 text-stone-500 lowercase tracking-normal text-xs font-light">
                        <li><a href="#" class="hover:text-dark-gold smooth-transition">Our Heritage</a></li>
                        <li><a href="#" class="hover:text-dark-gold smooth-transition">Bespoke Services</a></li>
                    </ul>
                </div>
                <div class="space-y-4">
                    <h4 class="text-stone-400 font-medium tracking-[0.3em] text-[11px]">Customer Care</h4>
                    <ul class="space-y-2.5 text-stone-500 lowercase tracking-normal text-xs font-light">
                        <li><a href="#" class="hover:text-dark-gold smooth-transition">Secure Logistics</a></li>
                        <li><a href="#" class="hover:text-dark-gold smooth-transition">Privacy Manifesto</a></li>
                    </ul>
                </div>
                <div class="space-y-4">
                    <h4 class="text-stone-400 font-medium tracking-[0.3em] text-[11px]">Contact</h4>
                    <p class="text-stone-500 lowercase tracking-normal text-xs font-light leading-relaxed normal-case">
                        Queries managed via secure client portal desks.
                    </p>
                </div>
            </div>

            <div class="text-center space-y-3 pt-4">
                <p class="text-stone-500 luxury-title text-base tracking-[0.2em] lowercase italic">crafted for connoisseurs of horological mechanics.</p>
                <p class="text-[9px] tracking-widest text-stone-700">&copy; 2026 Valencia Dial Atelier. All Civil Rights Registered.</p>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>