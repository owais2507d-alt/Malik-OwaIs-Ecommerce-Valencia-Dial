@extends('layouts.app')

@section('title', 'Valencia Dial - The Haute Horology Atelier')

@push('styles')
<style>
    /* ============================================
       ROOT THEME VARIABLES (Given & Extended)
       ============================================ */
    :root {
        --color-dark-gold: #d4af37;
        --color-light-gold: #e5c158;
        --color-pale-gold: #f5e6b0;
        --text-gold: #d4af37;
        --border-muted: #1c1c22;
        --bg-deep: #050507;
        --bg-card: #0b0b0e;
        --text-stone: #a1a1aa;
        --text-stone-light: #d4d4d8;
        --transition-smooth: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    /* ============================================
       BASE & UTILITY RESETS
       ============================================ */
    body {
        background-color: var(--bg-deep);
        color: #f5f5f7;
        font-family: 'Inter', 'Helvetica Neue', sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        letter-spacing: 0.02em;
    }

    .luxury-title {
        font-family: 'Playfair Display', 'Times New Roman', serif;
        font-weight: 300;
        letter-spacing: 0.1em;
    }

    .smooth-transition {
        transition: var(--transition-smooth);
    }

    .text-dark-gold {
        color: var(--color-dark-gold);
    }
    .border-dark-gold {
        border-color: var(--color-dark-gold);
    }
    .bg-dark-gold {
        background-color: var(--color-dark-gold);
    }
    .bg-deep {
        background-color: var(--bg-deep);
    }
    .bg-card {
        background-color: var(--bg-card);
    }
    .text-stone {
        color: var(--text-stone);
    }
    .border-muted {
        border-color: var(--border-muted);
    }

    .h-1px {
        height: 1px;
    }
    .w-16 {
        width: 4rem;
    }

    /* custom scroll */
    ::-webkit-scrollbar {
        width: 6px;
        background: #0a0a0d;
    }
    ::-webkit-scrollbar-thumb {
        background: var(--color-dark-gold);
        border-radius: 20px;
    }

    /* gold shimmer for accents */
    .gold-shimmer {
        background: linear-gradient(120deg, rgba(212, 175, 55, 0.05) 0%, rgba(212, 175, 55, 0.15) 50%, rgba(212, 175, 55, 0.05) 100%);
        background-size: 200% 100%;
        animation: shimmer 6s infinite linear;
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    /* hero glow */
    .hero-glow {
        position: absolute;
        width: 600px;
        height: 350px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.12) 0%, transparent 70%);
        filter: blur(120px);
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        pointer-events: none;
        z-index: 0;
    }

    /* category card overlay */
    .category-overlay {
        background: linear-gradient(0deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.2) 60%, transparent 100%);
    }

    /* trust icon hover */
    .trust-icon {
        transition: var(--transition-smooth);
    }
    .trust-icon:hover {
        color: var(--color-dark-gold);
        transform: translateY(-4px) scale(1.05);
    }

    /* button primary gold */
    .btn-gold {
        background: var(--color-dark-gold);
        color: #0a0a0d;
        border: 1px solid var(--color-dark-gold);
        font-weight: 600;
        letter-spacing: 0.2em;
        transition: var(--transition-smooth);
    }
    .btn-gold:hover {
        background: transparent;
        color: var(--color-dark-gold);
        border-color: var(--color-dark-gold);
        box-shadow: 0 0 30px rgba(212, 175, 55, 0.15);
    }

    .btn-outline-gold {
        background: transparent;
        color: var(--text-stone-light);
        border: 1px solid rgba(212, 175, 55, 0.3);
        letter-spacing: 0.2em;
        transition: var(--transition-smooth);
    }
    .btn-outline-gold:hover {
        background: var(--color-dark-gold);
        color: #0a0a0d;
        border-color: var(--color-dark-gold);
        box-shadow: 0 0 30px rgba(212, 175, 55, 0.2);
    }

    /* product card */
    .product-card {
        background: var(--bg-card);
        border: 1px solid var(--border-muted);
        transition: var(--transition-smooth);
    }
    .product-card:hover {
        border-color: rgba(212, 175, 55, 0.3);
        transform: translateY(-6px);
        box-shadow: 0 30px 60px rgba(0,0,0,0.8);
    }

    .product-img {
        background: #0a0a0e;
        transition: var(--transition-smooth);
    }
    .product-card:hover .product-img img {
        transform: scale(1.04);
    }

    .badge-limited {
        background: rgba(212, 175, 55, 0.15);
        border: 1px solid rgba(212, 175, 55, 0.3);
        color: var(--color-light-gold);
        font-size: 8px;
        letter-spacing: 0.15em;
        padding: 0.25rem 0.75rem;
        text-transform: uppercase;
    }

    .badge-sold {
        background: rgba(220, 38, 38, 0.15);
        border: 1px solid rgba(220, 38, 38, 0.3);
        color: #f87171;
        font-size: 8px;
        letter-spacing: 0.15em;
        padding: 0.25rem 0.75rem;
        text-transform: uppercase;
    }

    /* responsive fine-tune */
    @media (max-width: 640px) {
        .hero-glow {
            width: 300px;
            height: 200px;
            filter: blur(80px);
        }
        .luxury-title {
            font-size: 2.5rem;
        }
    }
</style>
@endpush

@section('content')

<!-- ============================================================
     HERO SECTION (Elevated, cinematic)
     ============================================================ -->
<section class="relative min-h-[70vh] flex items-center justify-center overflow-hidden border-b border-stone-900/40 bg-gradient-to-b from-[#0a0a0d] via-[#050507] to-[#040405] px-4 py-20 md:py-28">

    <div class="hero-glow"></div>

    <div class="relative z-10 max-w-5xl mx-auto text-center space-y-8">
        <div class="flex items-center justify-center space-x-4">
            <span class="h-px w-10 sm:w-16 bg-gradient-to-r from-transparent to-[#e5c158] opacity-60"></span>
            <span class="text-[10px] sm:text-xs uppercase tracking-[0.5em] text-dark-gold font-medium">ESTABLIHED. 2026</span>
            <span class="h-px w-10 sm:w-16 bg-gradient-to-l from-transparent to-[#e5c158] opacity-60"></span>
        </div>

        <h1 class="luxury-title text-5xl sm:text-7xl md:text-8xl font-light tracking-[0.12em] text-stone-200 uppercase leading-[1.1]">
            Valencia <br class="sm:hidden">
            <span class="font-normal text-dark-gold">Dial</span>
        </h1>

        <p class="text-stone-500 text-sm sm:text-base max-w-2xl mx-auto font-light leading-relaxed tracking-widest px-2">
            Step into our bespoke sanctuary. Every timepiece inside this digital vault is a mechanical masterpiece,
            curated for those who command time rather than follow it.
        </p>

        @guest
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
            <a href="{{ route('user.login') }}"
               class="btn-outline-gold px-8 py-4 text-[10px] uppercase tracking-[0.3em] font-medium min-w-[180px] text-center">
                Initialize Access
            </a>
            <a href="{{ route('user.register') }}"
               class="btn-gold px-8 py-4 text-[10px] uppercase tracking-[0.3em] font-medium min-w-[180px] text-center shadow-2xl shadow-black/50">
                Create Dossier
            </a>
        </div>
        @endguest

        <!-- scroll indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1 opacity-40">
            <span class="text-[8px] uppercase tracking-[0.3em] text-stone-500">Scroll</span>
            <div class="w-px h-10 bg-gradient-to-b from-dark-gold to-transparent"></div>
        </div>
    </div>
</section>

<!-- ============================================================
     PREMIUM URGENCY BANNER (Official Luxury Style)
     ============================================================ -->
<section class="relative py-14 md:py-20 bg-gradient-to-r from-[#0a0a0d] via-[#0b0b0e] to-[#0a0a0d] border-y border-stone-800/60 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        
        <div class="flex flex-col lg:flex-row items-center justify-between gap-10 lg:gap-16">
            
            <!-- Left Side - Message -->
            <div class="flex items-start gap-6">
                <div class="text-5xl md:text-6xl text-dark-gold opacity-90">⌛</div>
                <div>
                    <span class="inline-block px-4 py-1.5 text-[10px] uppercase tracking-[0.5em] font-semibold border border-dark-gold/30 text-dark-gold mb-3">
                        LIMITED ALLOCATION
                    </span>
                    <h3 class="text-2xl md:text-3xl text-white font-light tracking-wide luxury-title">
                        Only a Few Masterpieces Remain
                    </h3>
                    <p class="text-stone-400 mt-3 max-w-md text-[15px]">
                        These rare timepieces are allocated exclusively for true collectors. Once they’re gone, they’re gone.
                    </p>
                </div>
            </div>

            <!-- Center - Elegant Countdown -->
            <div class="flex-shrink-0">
                <div class="bg-[#111113] border border-dark-gold/20 rounded-2xl px-10 py-7 shadow-2xl shadow-black/80">
                    <div class="text-center mb-4">
                        <span class="text-xs uppercase tracking-[0.4em] text-stone-500 font-medium">Ends In</span>
                    </div>
                    
                    <div id="countdown" class="flex items-center justify-center gap-6 md:gap-8 text-center">
                        <div>
                            <span id="hours" class="block text-5xl md:text-6xl font-light text-dark-gold tabular-nums">47</span>
                            <span class="text-[10px] uppercase tracking-widest text-stone-500">Hours</span>
                        </div>
                        <span class="text-4xl text-stone-700 font-thin">:</span>
                        
                        <div>
                            <span id="minutes" class="block text-5xl md:text-6xl font-light text-dark-gold tabular-nums">19</span>
                            <span class="text-[10px] uppercase tracking-widest text-stone-500">Minutes</span>
                        </div>
                        <span class="text-4xl text-stone-700 font-thin">:</span>
                        
                        <div>
                            <span id="seconds" class="block text-5xl md:text-6xl font-light text-dark-gold tabular-nums">37</span>
                            <span class="text-[10px] uppercase tracking-widest text-stone-500">Seconds</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - CTA -->
            <div class="flex-shrink-0 text-center lg:text-left">
                <a href="#featured" 
                   class="group inline-flex items-center gap-3 bg-dark-gold hover:bg-white text-black hover:text-black font-semibold px-9 py-5 rounded-xl text-sm uppercase tracking-[0.125em] transition-all duration-300 hover:shadow-2xl hover:shadow-dark-gold/40">
                    <span>SECURE YOUR PIECE</span>
                    <span class="text-xl group-hover:translate-x-1 transition-transform">→</span>
                </a>
                <p class="text-[10px] text-stone-500 mt-4 tracking-widest">Only 12 pieces left in this drop</p>
            </div>
        </div>
    </div>

    <!-- Subtle decorative elements -->
    <div class="absolute top-0 left-1/3 w-px h-full bg-gradient-to-b from-transparent via-dark-gold/10 to-transparent"></div>
    <div class="absolute bottom-0 right-1/4 w-px h-2/3 bg-gradient-to-t from-transparent via-dark-gold/10 to-transparent"></div>
</section>

<!-- ============================================================
     TOP SELLING SECTION (carousel style grid)
     ============================================================ -->
<section class="py-16 md:py-24 bg-deep">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div>
                <span class="text-[9px] uppercase tracking-[0.4em] text-dark-gold font-semibold">Most Coveted</span>
                <h2 class="luxury-title text-3xl md:text-5xl font-light text-white mt-2">Top Sellers</h2>
                <div class="h-px w-16 bg-dark-gold/40 mt-3"></div>
            </div>
            <a href="#" class="text-[10px] uppercase tracking-[0.2em] text-stone-400 hover:text-dark-gold smooth-transition flex items-center gap-2 mt-4 md:mt-0">
                View All <span class="text-lg">→</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Top seller 1 -->
            <div class="product-card rounded-sm overflow-hidden group">
                <div class="product-img h-64 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=400&h=400&fit=crop" 
                         alt="Rolex Submariner" class="w-full h-full object-cover smooth-transition">
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 smooth-transition flex items-center justify-center backdrop-blur-[1px]">
                        <button class="border border-dark-gold/40 bg-black/70 px-5 py-2.5 text-[8px] uppercase tracking-[0.25em] text-stone-200 hover:bg-dark-gold hover:text-black smooth-transition font-medium">
                            Quick View
                        </button>
                    </div>
                    <span class="badge-limited absolute top-3 right-3">Limited</span>
                </div>
                <div class="p-5 space-y-2">
                    <div class="flex justify-between items-start">
                        <span class="text-[9px] uppercase tracking-widest text-stone-500 font-semibold">Rolex</span>
                        <span class="text-sm font-medium text-dark-gold">$12,450</span>
                    </div>
                    <h3 class="text-base font-medium text-white group-hover:text-dark-gold smooth-transition">Submariner Date</h3>
                    <p class="text-stone-500 text-[11px] font-light leading-relaxed line-clamp-2">Oystersteel, black Cerachrom, 41mm, cal. 3235</p>
                </div>
            </div>

            <!-- Top seller 2 -->
            <div class="product-card rounded-sm overflow-hidden group">
                <div class="product-img h-64 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1533139502658-0198f920d8e8?w=400&h=400&fit=crop" 
                         alt="Omega Speedmaster" class="w-full h-full object-cover smooth-transition">
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 smooth-transition flex items-center justify-center backdrop-blur-[1px]">
                        <button class="border border-dark-gold/40 bg-black/70 px-5 py-2.5 text-[8px] uppercase tracking-[0.25em] text-stone-200 hover:bg-dark-gold hover:text-black smooth-transition font-medium">
                            Quick View
                        </button>
                    </div>
                    <span class="badge-sold absolute top-3 right-3">Sold Out</span>
                </div>
                <div class="p-5 space-y-2">
                    <div class="flex justify-between items-start">
                        <span class="text-[9px] uppercase tracking-widest text-stone-500 font-semibold">Omega</span>
                        <span class="text-sm font-medium text-dark-gold">$8,750</span>
                    </div>
                    <h3 class="text-base font-medium text-white group-hover:text-dark-gold smooth-transition">Speedmaster Pro</h3>
                    <p class="text-stone-500 text-[11px] font-light leading-relaxed line-clamp-2">Moonwatch, manual, hesalite, 42mm</p>
                </div>
            </div>

            <!-- Top seller 3 -->
            <div class="product-card rounded-sm overflow-hidden group">
                <div class="product-img h-64 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1542496658-e33a6d0d50f6?w=400&h=400&fit=crop" 
                         alt="Cartier Santos" class="w-full h-full object-cover smooth-transition">
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 smooth-transition flex items-center justify-center backdrop-blur-[1px]">
                        <button class="border border-dark-gold/40 bg-black/70 px-5 py-2.5 text-[8px] uppercase tracking-[0.25em] text-stone-200 hover:bg-dark-gold hover:text-black smooth-transition font-medium">
                            Quick View
                        </button>
                    </div>
                    <span class="badge-limited absolute top-3 right-3">Limited</span>
                </div>
                <div class="p-5 space-y-2">
                    <div class="flex justify-between items-start">
                        <span class="text-[9px] uppercase tracking-widest text-stone-500 font-semibold">Cartier</span>
                        <span class="text-sm font-medium text-dark-gold">$9,200</span>
                    </div>
                    <h3 class="text-base font-medium text-white group-hover:text-dark-gold smooth-transition">Santos de Cartier</h3>
                    <p class="text-stone-500 text-[11px] font-light leading-relaxed line-clamp-2">Steel, 7-sided crown, sapphire</p>
                </div>
            </div>

            <!-- Top seller 4 -->
            <div class="product-card rounded-sm overflow-hidden group">
                <div class="product-img h-64 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1587836374828-4dbafa94cf0e?w=400&h=400&fit=crop" 
                         alt="Audemars Piguet" class="w-full h-full object-cover smooth-transition">
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 smooth-transition flex items-center justify-center backdrop-blur-[1px]">
                        <button class="border border-dark-gold/40 bg-black/70 px-5 py-2.5 text-[8px] uppercase tracking-[0.25em] text-stone-200 hover:bg-dark-gold hover:text-black smooth-transition font-medium">
                            Quick View
                        </button>
                    </div>
                </div>
                <div class="p-5 space-y-2">
                    <div class="flex justify-between items-start">
                        <span class="text-[9px] uppercase tracking-widest text-stone-500 font-semibold">Audemars Piguet</span>
                        <span class="text-sm font-medium text-dark-gold">$34,500</span>
                    </div>
                    <h3 class="text-base font-medium text-white group-hover:text-dark-gold smooth-transition">Royal Oak Selfwinding</h3>
                    <p class="text-stone-500 text-[11px] font-light leading-relaxed line-clamp-2">41mm, blue dial, Grande Tapisserie</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     CATEGORY SECTIONS (curated collections)
     ============================================================ -->
<section class="py-16 md:py-24 bg-[#08080b]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-[9px] uppercase tracking-[0.4em] text-dark-gold font-semibold">Explore by collection</span>
            <h2 class="luxury-title text-3xl md:text-5xl font-light text-white mt-2">The Atelier Categories</h2>
            <div class="h-px w-16 bg-dark-gold/40 mx-auto mt-3"></div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            <!-- Category 1 -->
            <a href="#" class="group relative overflow-hidden rounded-sm aspect-[3/4] bg-[#0f0f13] border border-stone-900/60 smooth-transition hover:border-dark-gold/40">
                <img src="https://images.unsplash.com/photo-1523170335258-f5ed11844a49?w=400&h=500&fit=crop" 
                     alt="Dress Watches" class="w-full h-full object-cover smooth-transition group-hover:scale-105">
                <div class="absolute inset-0 category-overlay flex items-end p-5">
                    <div>
                        <span class="text-[9px] uppercase tracking-[0.3em] text-dark-gold font-medium">Elegance</span>
                        <h3 class="text-xl font-light text-white">Dress</h3>
                    </div>
                </div>
            </a>
            <!-- Category 2 -->
            <a href="#" class="group relative overflow-hidden rounded-sm aspect-[3/4] bg-[#0f0f13] border border-stone-900/60 smooth-transition hover:border-dark-gold/40">
                <img src="https://images.unsplash.com/photo-1614164185128-e4ec99c436d7?w=400&h=500&fit=crop" 
                     alt="Diver Watches" class="w-full h-full object-cover smooth-transition group-hover:scale-105">
                <div class="absolute inset-0 category-overlay flex items-end p-5">
                    <div>
                        <span class="text-[9px] uppercase tracking-[0.3em] text-dark-gold font-medium">Adventure</span>
                        <h3 class="text-xl font-light text-white">Diver</h3>
                    </div>
                </div>
            </a>
            <!-- Category 3 -->
            <a href="#" class="group relative overflow-hidden rounded-sm aspect-[3/4] bg-[#0f0f13] border border-stone-900/60 smooth-transition hover:border-dark-gold/40">
                <img src="https://images.unsplash.com/photo-1533139502658-0198f920d8e8?w=400&h=500&fit=crop" 
                     alt="Chronograph" class="w-full h-full object-cover smooth-transition group-hover:scale-105">
                <div class="absolute inset-0 category-overlay flex items-end p-5">
                    <div>
                        <span class="text-[9px] uppercase tracking-[0.3em] text-dark-gold font-medium">Precision</span>
                        <h3 class="text-xl font-light text-white">Chronograph</h3>
                    </div>
                </div>
            </a>
            <!-- Category 4 -->
            <a href="#" class="group relative overflow-hidden rounded-sm aspect-[3/4] bg-[#0f0f13] border border-stone-900/60 smooth-transition hover:border-dark-gold/40">
                <img src="https://images.unsplash.com/photo-1587836374828-4dbafa94cf0e?w=400&h=500&fit=crop" 
                     alt="Haute Horology" class="w-full h-full object-cover smooth-transition group-hover:scale-105">
                <div class="absolute inset-0 category-overlay flex items-end p-5">
                    <div>
                        <span class="text-[9px] uppercase tracking-[0.3em] text-dark-gold font-medium">Artistry</span>
                        <h3 class="text-xl font-light text-white">Haute</h3>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- ============================================================
     FEATURED PRODUCTS (full grid with spec overlay)
     ============================================================ -->
<section id="featured" class="py-16 md:py-24 bg-deep">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div>
                <span class="text-[9px] uppercase tracking-[0.4em] text-dark-gold font-semibold">Masterpiece Collection</span>
                <h2 class="luxury-title text-3xl md:text-5xl font-light text-white mt-2">Featured Timepieces</h2>
                <div class="h-px w-16 bg-dark-gold/40 mt-3"></div>
            </div>
            <a href="#" class="text-[10px] uppercase tracking-[0.2em] text-stone-400 hover:text-dark-gold smooth-transition flex items-center gap-2 mt-4 md:mt-0">
                View All <span class="text-lg">→</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-7">
            <!-- Featured 1 -->
            <div class="product-card rounded-sm overflow-hidden group">
                <div class="product-img h-80 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=500&h=500&fit=crop" 
                         alt="Rolex GMT-Master II" class="w-full h-full object-cover smooth-transition">
                    <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 smooth-transition flex items-center justify-center backdrop-blur-[2px]">
                        <button class="border border-dark-gold/50 bg-black/80 px-6 py-3 text-[8px] uppercase tracking-[0.25em] text-stone-200 hover:bg-dark-gold hover:text-black smooth-transition font-medium">
                            View Specs
                        </button>
                    </div>
                    <span class="badge-limited absolute top-4 right-4">Limited</span>
                </div>
                <div class="p-6 space-y-2.5">
                    <div class="flex justify-between items-center">
                        <span class="text-[9px] uppercase tracking-widest text-stone-500 font-semibold">Rolex</span>
                        <span class="text-sm font-medium text-dark-gold">$16,800</span>
                    </div>
                    <h3 class="text-lg font-medium text-white group-hover:text-dark-gold smooth-transition">GMT-Master II</h3>
                    <p class="text-stone-400 text-xs font-light leading-relaxed">Oystersteel, Cerachrom bezel, caliber 3285, 40mm</p>
                    <button class="w-full mt-3 btn-gold py-3 text-[9px] uppercase tracking-[0.2em] font-semibold">Acquire</button>
                </div>
            </div>

            <!-- Featured 2 -->
            <div class="product-card rounded-sm overflow-hidden group">
                <div class="product-img h-80 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1542496658-e33a6d0d50f6?w=500&h=500&fit=crop" 
                         alt="IWC Portugieser" class="w-full h-full object-cover smooth-transition">
                    <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 smooth-transition flex items-center justify-center backdrop-blur-[2px]">
                        <button class="border border-dark-gold/50 bg-black/80 px-6 py-3 text-[8px] uppercase tracking-[0.25em] text-stone-200 hover:bg-dark-gold hover:text-black smooth-transition font-medium">
                            View Specs
                        </button>
                    </div>
                    <span class="badge-sold absolute top-4 right-4">Sold Out</span>
                </div>
                <div class="p-6 space-y-2.5">
                    <div class="flex justify-between items-center">
                        <span class="text-[9px] uppercase tracking-widest text-stone-500 font-semibold">IWC</span>
                        <span class="text-sm font-medium text-dark-gold">$11,200</span>
                    </div>
                    <h3 class="text-lg font-medium text-white group-hover:text-dark-gold smooth-transition">Portugieser Automatic</h3>
                    <p class="text-stone-400 text-xs font-light leading-relaxed">42mm, 7-day power reserve, silver dial</p>
                    <button disabled class="w-full mt-3 py-3 text-[9px] uppercase tracking-[0.2em] font-semibold border border-stone-800 text-stone-600 bg-stone-950/40 cursor-not-allowed">Depleted</button>
                </div>
            </div>

            <!-- Featured 3 -->
            <div class="product-card rounded-sm overflow-hidden group">
                <div class="product-img h-80 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1587836374828-4dbafa94cf0e?w=500&h=500&fit=crop" 
                         alt="AP Royal Oak Offshore" class="w-full h-full object-cover smooth-transition">
                    <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 smooth-transition flex items-center justify-center backdrop-blur-[2px]">
                        <button class="border border-dark-gold/50 bg-black/80 px-6 py-3 text-[8px] uppercase tracking-[0.25em] text-stone-200 hover:bg-dark-gold hover:text-black smooth-transition font-medium">
                            View Specs
                        </button>
                    </div>
                    <span class="badge-limited absolute top-4 right-4">Limited</span>
                </div>
                <div class="p-6 space-y-2.5">
                    <div class="flex justify-between items-center">
                        <span class="text-[9px] uppercase tracking-widest text-stone-500 font-semibold">Audemars Piguet</span>
                        <span class="text-sm font-medium text-dark-gold">$47,200</span>
                    </div>
                    <h3 class="text-lg font-medium text-white group-hover:text-dark-gold smooth-transition">Royal Oak Offshore</h3>
                    <p class="text-stone-400 text-xs font-light leading-relaxed">42mm, forged carbon, chronograph, caliber 4404</p>
                    <button class="w-full mt-3 btn-gold py-3 text-[9px] uppercase tracking-[0.2em] font-semibold">Acquire</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     TRUST BUILDING SECTION (social proof + values)
     ============================================================ -->
<section class="py-16 md:py-20 bg-[#08080b] border-t border-stone-900/40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-[9px] uppercase tracking-[0.4em] text-dark-gold font-semibold">Why Valencia Dial</span>
            <h2 class="luxury-title text-3xl md:text-5xl font-light text-white mt-2">The Hallmarks of Trust</h2>
            <div class="h-px w-16 bg-dark-gold/40 mx-auto mt-3"></div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <!-- Trust 1 -->
            <div class="space-y-3">
                <div class="text-4xl trust-icon text-stone-400">🔒</div>
                <h4 class="text-xs uppercase tracking-[0.2em] text-stone-300 font-medium">Secure Vault</h4>
                <p class="text-stone-500 text-[11px] font-light leading-relaxed max-w-xs mx-auto">256-bit encryption &amp; insured shipments</p>
            </div>
            <!-- Trust 2 -->
            <div class="space-y-3">
                <div class="text-4xl trust-icon text-stone-400">⏳</div>
                <h4 class="text-xs uppercase tracking-[0.2em] text-stone-300 font-medium">Horology Expertise</h4>
                <p class="text-stone-500 text-[11px] font-light leading-relaxed max-w-xs mx-auto">Master watchmakers with 50+ years collective</p>
            </div>
            <!-- Trust 3 -->
            <div class="space-y-3">
                <div class="text-4xl trust-icon text-stone-400">📜</div>
                <h4 class="text-xs uppercase tracking-[0.2em] text-stone-300 font-medium">Certificate of Authenticity</h4>
                <p class="text-stone-500 text-[11px] font-light leading-relaxed max-w-xs mx-auto">Every piece verified &amp; serialized</p>
            </div>
            <!-- Trust 4 -->
            <div class="space-y-3">
                <div class="text-4xl trust-icon text-stone-400">🤝</div>
                <h4 class="text-xs uppercase tracking-[0.2em] text-stone-300 font-medium">Concierge Service</h4>
                <p class="text-stone-500 text-[11px] font-light leading-relaxed max-w-xs mx-auto">Dedicated support &amp; after-sales care</p>
            </div>
        </div>

        <!-- client logos / testimonial snippet -->
        <div class="mt-16 border-t border-stone-900/30 pt-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-6 opacity-60">
                <span class="text-[9px] uppercase tracking-[0.3em] text-stone-500">Trusted by</span>
                <span class="text-stone-400 text-xs font-light tracking-widest">✦ Forbes</span>
                <span class="text-stone-400 text-xs font-light tracking-widest">✦ Robb Report</span>
                <span class="text-stone-400 text-xs font-light tracking-widest">✦ Hodinkee</span>
            </div>
            <div class="flex items-center gap-3 text-stone-500 text-xs">
                <span class="text-dark-gold text-lg">★</span>
                <span>4.9 / 5.0</span>
                <span class="h-4 w-px bg-stone-800"></span>
                <span>120+ verified reviews</span>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     FINAL CTA / NEWSLETTER (elevated)
     ============================================================ -->
<section class="py-16 md:py-20 bg-gradient-to-b from-[#050507] to-[#0a0a0d] border-t border-stone-900/40">
    <div class="max-w-3xl mx-auto px-4 text-center space-y-6">
        <span class="text-[9px] uppercase tracking-[0.4em] text-dark-gold font-semibold">Join the inner circle</span>
        <h2 class="luxury-title text-3xl md:text-5xl font-light text-white">Subscribe to <span class="text-dark-gold">Vault</span> Dispatch</h2>
        <p class="text-stone-400 text-sm font-light max-w-xl mx-auto leading-relaxed">
            Receive exclusive allocations, private viewing invites, and horological insights — before the public.
        </p>
        <form class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto mt-6">
            <input type="email" placeholder="Your email address" 
                   class="flex-1 bg-[#0f0f13] border border-stone-800 px-5 py-3.5 text-sm text-stone-200 placeholder-stone-600 focus:border-dark-gold/50 outline-none smooth-transition">
            <button type="submit" class="btn-gold px-8 py-3.5 text-[9px] uppercase tracking-[0.25em] font-semibold whitespace-nowrap">
                Subscribe
            </button>
        </form>
        <p class="text-[9px] text-stone-600 tracking-widest">No spam. Unsubscribe anytime.</p>
    </div>
</section>

@endsection

@push('scripts')
@push('scripts')
<script>
    // Countdown Timer
    function startCountdown() {
        let hours = 47;
        let minutes = 19;
        let seconds = 37;

        const hoursEl = document.getElementById('hours');
        const minutesEl = document.getElementById('minutes');
        const secondsEl = document.getElementById('seconds');

        setInterval(() => {
            seconds--;
            if (seconds < 0) {
                seconds = 59;
                minutes--;
            }
            if (minutes < 0) {
                minutes = 59;
                hours--;
            }
            if (hours < 0) {
                hours = 0;
                minutes = 0;
                seconds = 0;
            }

            hoursEl.textContent = String(hours).padStart(2, '0');
            minutesEl.textContent = String(minutes).padStart(2, '0');
            secondsEl.textContent = String(seconds).padStart(2, '0');
        }, 1000);
    }

    document.addEventListener('DOMContentLoaded', startCountdown);
</script>
@endpush
@endpush