@extends('layouts.app')

@section('title', 'Valencia Dial - The Haute Horology Atelier')

@push('styles')
<style>
    /* ============================================
       ROOT THEME VARIABLES
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

    /* Pulse animation */
    @keyframes pulse {
        0%, 100% { opacity: 0.4; }
        50% { opacity: 1; }
    }
    .animate-pulse {
        animation: pulse 2s ease-in-out infinite;
    }

    /* AOS Override */
    [data-aos] {
        pointer-events: none;
    }
    [data-aos].aos-animate {
        pointer-events: auto;
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
     HERO SECTION
     ============================================================ -->
<section class="relative min-h-[70vh] flex items-center justify-center overflow-hidden border-b border-stone-900/40 bg-gradient-to-b from-[#0a0a0d] via-[#050507] to-[#040405] px-4 py-20 md:py-28">
    <div class="hero-glow"></div>

    <div class="relative z-10 max-w-5xl mx-auto text-center space-y-8">
        <div class="flex items-center justify-center space-x-4" data-aos="fade-down" data-aos-delay="200">
            <span class="h-px w-10 sm:w-16 bg-gradient-to-r from-transparent to-[#e5c158] opacity-60"></span>
            <span class="text-[10px] sm:text-xs uppercase tracking-[0.5em] text-dark-gold font-medium">ESTABLISHED. 2026</span>
            <span class="h-px w-10 sm:w-16 bg-gradient-to-l from-transparent to-[#e5c158] opacity-60"></span>
        </div>

        <h1 class="luxury-title text-5xl sm:text-7xl md:text-8xl font-light tracking-[0.12em] text-stone-200 uppercase leading-[1.1]" data-aos="zoom-in" data-aos-delay="300">
            Valencia <br class="sm:hidden">
            <span class="font-normal text-dark-gold">Dial</span>
        </h1>

        <p class="text-stone-500 text-sm sm:text-base max-w-2xl mx-auto font-light leading-relaxed tracking-widest px-2" data-aos="fade-up" data-aos-delay="400">
            Step into our sanctuary of refined curation—a digital atelier where exceptional craftsmanship meets
            timeless design. Every piece within our collection is selected for those who shape their own narrative,
            transcending borders and convention.
        </p>

        @guest
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4" data-aos="fade-up" data-aos-delay="500">
            <a href="{{ route('user.login') }}"
               class="relative overflow-hidden px-8 py-4 text-[10px] uppercase tracking-[0.3em] font-medium min-w-[180px] text-center transition-all duration-500 ease-out border border-[#e5c158]/40 text-[#e5c158] hover:text-stone-950 hover:border-[#e5c158] hover:shadow-[0_0_30px_rgba(229,193,88,0.15)] group">
                <span class="relative z-10">Login</span>
                <span class="absolute inset-0 bg-[#e5c158] scale-x-0 group-hover:scale-x-100 transition-transform duration-500 ease-out origin-left"></span>
            </a>

            <a href="{{ route('user.register') }}"
               class="relative overflow-hidden px-8 py-4 text-[10px] uppercase tracking-[0.3em] font-medium min-w-[180px] text-center transition-all duration-500 ease-out bg-[#e5c158] text-stone-950 hover:text-stone-950 border border-[#e5c158] shadow-2xl shadow-black/50 hover:shadow-[0_0_40px_rgba(229,193,88,0.25)] group">
                <span class="relative z-10">Create Account</span>
                <span class="absolute inset-0 bg-stone-950 scale-x-0 group-hover:scale-x-100 transition-transform duration-500 ease-out origin-left"></span>
                <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700 ease-in-out"></span>
            </a>
        </div>
        @endguest

        <!-- scroll indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1 opacity-40" data-aos="fade-up" data-aos-delay="600">
            <span class="text-[8px] uppercase tracking-[0.3em] text-stone-500">Scroll</span>
            <div class="w-px h-10 bg-gradient-to-b from-dark-gold to-transparent"></div>
        </div>
    </div>
</section>

<!-- ============================================================
     PREMIUM URGENCY BANNER
     ============================================================ -->
<section class="relative py-14 md:py-20 bg-gradient-to-r from-[#0a0a0d] via-[#0b0b0e] to-[#0a0a0d] border-y border-stone-800/60 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-10 lg:gap-16">
            <!-- Left Side - Message -->
            <div class="flex items-start gap-6" data-aos="fade-right" data-aos-duration="800">
                <div class="text-5xl md:text-6xl text-dark-gold opacity-90">⌛</div>
                <div>
                    <span class="inline-block px-4 py-1.5 text-[10px] uppercase tracking-[0.5em] font-semibold border border-dark-gold/30 text-dark-gold mb-3">
                        LIMITED ALLOCATION
                    </span>
                    <h3 class="text-2xl md:text-3xl text-white font-light tracking-wide luxury-title">
                        Only a Few Masterpieces Remain
                    </h3>
                    <p class="text-stone-400 mt-3 max-w-md text-[15px]">
                        These rare timepieces are allocated exclusively for true collectors. Once they're gone, they're gone.
                    </p>
                </div>
            </div>

            <!-- Center - Countdown -->
            <div class="flex-shrink-0" data-aos="zoom-in" data-aos-delay="200" data-aos-duration="800">
                <div class="bg-[#111113] border border-dark-gold/20 rounded-2xl px-8 md:px-10 py-7 shadow-2xl shadow-black/80">
                    <div class="text-center mb-4">
                        <span class="text-xs uppercase tracking-[0.4em] text-stone-500 font-medium">Ends In</span>
                    </div>
                    <div id="countdown-timer" class="flex items-center justify-center gap-4 md:gap-8 text-center">
                        <div>
                            <span id="countdown-hours" class="block text-4xl md:text-6xl font-light text-dark-gold tabular-nums">47</span>
                            <span class="text-[10px] uppercase tracking-widest text-stone-500">Hours</span>
                        </div>
                        <span class="text-3xl md:text-4xl text-stone-700 font-thin">:</span>
                        <div>
                            <span id="countdown-minutes" class="block text-4xl md:text-6xl font-light text-dark-gold tabular-nums">19</span>
                            <span class="text-[10px] uppercase tracking-widest text-stone-500">Minutes</span>
                        </div>
                        <span class="text-3xl md:text-4xl text-stone-700 font-thin">:</span>
                        <div>
                            <span id="countdown-seconds" class="block text-4xl md:text-6xl font-light text-dark-gold tabular-nums">37</span>
                            <span class="text-[10px] uppercase tracking-widest text-stone-500">Seconds</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - CTA -->
            <div class="flex-shrink-0 text-center lg:text-left" data-aos="fade-left" data-aos-delay="400" data-aos-duration="800">
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
     TOP SELLING SECTION
     ============================================================ -->
<section class="py-20 md:py-28 bg-[#050507] border-b border-stone-900/40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16" data-aos="fade-up">
            <div class="space-y-2">
                <span class="text-[9px] uppercase tracking-[0.5em] text-[#e5c158] font-medium block">Most Coveted Assets</span>
                <h2 class="text-3xl md:text-5xl font-light tracking-widest text-stone-100 uppercase">Top Sellers</h2>
                <div class="h-[1px] w-20 bg-gradient-to-r from-[#e5c158] to-transparent mt-4"></div>
            </div>
            <a href="#" class="group text-[10px] uppercase tracking-[0.3em] text-stone-400 hover:text-[#e5c158] transition-all flex items-center gap-3 mt-6 md:mt-0 font-medium">
                View Entire Collection
                <span class="text-xs transform transition-transform group-hover:translate-x-1 duration-300">→</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 xl:gap-8">
            <!-- Top Seller items with data-aos -->
            @php
                $topSellers = [
                    ['brand' => 'Rolex', 'model' => 'Submariner Date', 'price' => '$12,450.00', 'image' => 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=400&h=400&fit=crop', 'badge' => 'Limited', 'badgeClass' => 'badge-limited', 'desc' => 'Oystersteel profile featuring a deep black Cerachrom configuration, 41mm architecture.'],
                    ['brand' => 'Omega', 'model' => 'Speedmaster Pro', 'price' => '$8,750.00', 'image' => 'https://images.unsplash.com/photo-1533139502658-0198f920d8e8?w=400&h=400&fit=crop', 'badge' => 'Depleted', 'badgeClass' => 'badge-sold', 'desc' => 'Historic Moonwatch caliber featuring classic tactical manual winding mechanics.'],
                    ['brand' => 'Cartier', 'model' => 'Santos de Cartier', 'price' => '$9,200.00', 'image' => 'https://images.unsplash.com/photo-1542496658-e33a6d0d50f6?w=400&h=400&fit=crop', 'badge' => 'Limited', 'badgeClass' => 'badge-limited', 'desc' => 'Sculpted pristine steel architecture paired with a 7-sided sapphire crown assembly.'],
                    ['brand' => 'Audemars Piguet', 'model' => 'Royal Oak Selfwinding', 'price' => '$34,500.00', 'image' => 'https://images.unsplash.com/photo-1587836374828-4dbafa94cf0e?w=400&h=400&fit=crop', 'badge' => 'Available', 'badgeClass' => 'badge-available', 'desc' => '41mm case configuration executing an intricate signature Grande Tapisserie pattern dial.'],
                ];
            @endphp

            @foreach($topSellers as $index => $item)
            <div class="group relative flex flex-col justify-between border border-stone-900/60 p-4 bg-[#0a0a0d]/40 transition-all duration-500 hover:bg-[#0a0a0d] hover:border-stone-800 hover:shadow-[0_25px_50px_-12px_rgba(0,0,0,0.7)]" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <div class="w-full h-80 bg-[#050507] overflow-hidden relative p-2 border border-stone-950">
                    <img src="{{ $item['image'] }}"
                         alt="{{ $item['brand'] }} {{ $item['model'] }}"
                         class="w-full h-full object-cover transition-transform duration-1000 scale-95 group-hover:scale-100">
                    <div class="absolute inset-0 bg-black/70 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center backdrop-blur-[2px]">
                        <button class="border border-[#e5c158]/40 bg-[#050507] px-5 py-3 text-[9px] uppercase tracking-[0.25em] text-stone-200 hover:bg-[#e5c158] hover:text-black transition-all font-medium">
                            Inspect Blueprint
                        </button>
                    </div>
                    <span class="absolute top-4 right-4 text-[8px] uppercase tracking-widest font-semibold px-2.5 py-1 {{ $item['badgeClass'] }}">
                        {{ $item['badge'] }}
                    </span>
                </div>
                <div class="mt-6 space-y-3 px-1">
                    <div class="flex justify-between items-baseline">
                        <span class="text-[10px] uppercase tracking-[0.2em] text-stone-500 font-bold">{{ $item['brand'] }}</span>
                        <span class="text-xs font-semibold tracking-wide text-[#e5c158]">{{ $item['price'] }}</span>
                    </div>
                    <h3 class="text-base font-light text-stone-200 tracking-wide group-hover:text-[#e5c158] transition-colors duration-300">{{ $item['model'] }}</h3>
                    <p class="text-stone-500 text-[11px] font-light leading-relaxed tracking-wide line-clamp-2 h-9 border-t border-stone-900/50 pt-2">{{ $item['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ============================================================
     CATEGORY SECTIONS
     ============================================================ -->
<section class="py-20 md:py-28 bg-[#050507] border-b border-stone-900/40 relative overflow-hidden">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[300px] bg-[#e5c158]/[0.02] blur-[120px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
        <div class="text-center max-w-2xl mx-auto mb-16" data-aos="fade-up">
            <span class="text-[9px] uppercase tracking-[0.5em] text-[#e5c158] font-medium block bg-[#e5c158]/5 py-1.5 px-4 rounded-full w-fit mx-auto backdrop-blur-sm border border-[#e5c158]/10">Curated Ecosystem</span>
            <h2 class="text-3xl md:text-5xl font-light tracking-[0.18em] text-stone-100 uppercase mt-5 gold-glow">The Atelier Categories</h2>
            <div class="h-[1px] w-20 bg-gradient-to-r from-transparent via-[#e5c158] to-transparent mx-auto mt-4"></div>
            <p class="text-stone-500 text-[11px] tracking-[0.2em] uppercase mt-5 font-light">exclusive selections · timeless craft</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 xl:gap-10 auto-rows-fr">
            @php
                $categories = [
                    ['name' => 'Watches', 'image' => 'https://images.unsplash.com/photo-1547996160-81dfa63595aa?w=600&h=800&fit=crop', 'label' => 'Horology'],
                    ['name' => 'Earpods', 'image' => 'https://images.unsplash.com/photo-1600294037681-c80b4cb5b434?w=600&h=800&fit=crop', 'label' => 'Acoustics'],
                    ['name' => 'Headphones', 'image' => 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=600&h=800&fit=crop', 'label' => 'Immersive'],
                ];
            @endphp

            @foreach($categories as $index => $category)
            <a href="#" class="group relative flex flex-col justify-between rounded-2xl bg-[#0a0a0d]/60 backdrop-blur-sm border border-stone-900/50 p-4 transition-all duration-500 hover:bg-[#0f0f13] hover:border-stone-800/80 shadow-advanced card-advanced overflow-hidden" data-aos="fade-up" data-aos-delay="{{ $index * 150 }}">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MDAiIGhlaWdodD0iNDAwIj48ZmlsdGVyIGlkPSJmIj48ZmVUdXJidWxlbmNlIHR5cGU9ImZyYWN0YWxOb2lzZSIgYmFzZUZyZXF1ZW5jeT0iLjc1IiBudW1PY3RhdmVzPSIzIiAvPjwvZmlsdGVyPjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iNDAwIiBmaWx0ZXI9InVybCgjZikiIG9wYWNpdHk9IjAuMDMiIC8+PC9zdmc+')] opacity-30 pointer-events-none"></div>
                <div class="relative w-full h-[400px] sm:h-[460px] overflow-hidden rounded-xl bg-[#050507] border border-stone-950/80">
                    <img src="{{ $category['image'] }}"
                         alt="Premium {{ $category['name'] }}"
                         class="w-full h-full object-cover img-zoom scale-[1.02] transition-transform duration-1000 ease-out">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-70 group-hover:opacity-50 transition-opacity duration-700"></div>
                    <div class="absolute inset-0 overlay-shine"></div>
                    <div class="absolute top-4 left-4 bg-black/40 backdrop-blur-sm px-3 py-1 rounded-full border border-white/5">
                        <span class="text-[8px] tracking-[0.25em] text-[#e5c158] font-bold uppercase">curated</span>
                    </div>
                </div>
                <div class="mt-5 space-y-2 px-1 relative">
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] uppercase tracking-[0.3em] text-stone-400 font-bold group-hover:text-[#e5c158] transition-colors duration-300">{{ $category['label'] }}</span>
                        <span class="text-[11px] tracking-widest text-stone-500 group-hover:text-stone-300 group-hover:translate-x-1 transition-all duration-300 flex items-center gap-1">Explore <span class="text-[#e5c158]/70 text-xs">→</span></span>
                    </div>
                    <h3 class="text-xl font-light text-stone-100 tracking-widest uppercase">{{ $category['name'] }}</h3>
                    <div class="h-[1px] w-12 bg-stone-800 line-extend group-hover:bg-[#e5c158]/40"></div>
                    <div class="flex items-center gap-2 pt-1">
                        <span class="text-[9px] uppercase tracking-[0.15em] text-stone-600">exclusive</span>
                        <span class="w-1 h-1 rounded-full bg-stone-700"></span>
                        <span class="text-[9px] uppercase tracking-[0.15em] text-stone-600">limited</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- ============================================================
     FEATURED PRODUCTS
     ============================================================ -->
<section id="featured" class="py-16 md:py-24 bg-deep relative overflow-hidden">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[400px] bg-[#e5c158]/[0.02] blur-[140px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-14" data-aos="fade-up">
            <div>
                <span class="text-[9px] uppercase tracking-[0.5em] text-[#e5c158] font-medium block bg-[#e5c158]/5 py-1.5 px-4 rounded-full w-fit backdrop-blur-sm border border-[#e5c158]/10">Masterpiece Collection</span>
                <h2 class="luxury-title text-3xl md:text-5xl font-light text-white mt-4 tracking-wide">Featured <span class="text-dark-gold">Timepieces</span></h2>
                <div class="h-[1px] w-20 bg-gradient-to-r from-[#e5c158] to-transparent mt-4"></div>
                <p class="text-stone-500 text-[11px] tracking-[0.2em] uppercase mt-3 font-light">Curated for the discerning collector</p>
            </div>
            <a href="#" class="group text-[10px] uppercase tracking-[0.3em] text-stone-400 hover:text-[#e5c158] transition-all flex items-center gap-3 mt-6 md:mt-0 font-medium border border-stone-800/50 px-5 py-2.5 rounded-full hover:border-[#e5c158]/30 hover:bg-[#e5c158]/5">
                View All Collections
                <span class="text-sm transform transition-transform group-hover:translate-x-1 duration-300">→</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 xl:gap-8">
            @php
                $featured = [
                    [
                        'brand' => 'Rolex',
                        'model' => 'GMT-Master II',
                        'price' => '$16,800',
                        'image' => 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=600&h=600&fit=crop',
                        'badge' => 'Limited',
                        'badgeClass' => 'badge-limited',
                        'specs' => '40mm · Cal. 3285',
                        'rating' => '4.9',
                        'stock' => '2 left in stock',
                        'edition' => '2026 Edition'
                    ],
                    [
                        'brand' => 'IWC',
                        'model' => 'Portugieser Automatic',
                        'price' => '$11,200',
                        'image' => 'https://images.unsplash.com/photo-1542496658-e33a6d0d50f6?w=600&h=600&fit=crop',
                        'badge' => 'Sold Out',
                        'badgeClass' => 'badge-sold',
                        'specs' => '42mm · 7-day reserve',
                        'rating' => '4.8',
                        'stock' => 'Currently unavailable',
                        'edition' => 'Classic'
                    ],
                    [
                        'brand' => 'Audemars Piguet',
                        'model' => 'Royal Oak Offshore',
                        'price' => '$47,200',
                        'image' => 'https://images.unsplash.com/photo-1587836374828-4dbafa94cf0e?w=600&h=600&fit=crop',
                        'badge' => 'Limited',
                        'badgeClass' => 'badge-limited',
                        'specs' => '42mm · Cal. 4404',
                        'rating' => '4.9',
                        'stock' => '1 left in stock',
                        'edition' => 'Iconic'
                    ],
                ];
            @endphp

            @foreach($featured as $index => $item)
            <div class="group relative bg-gradient-to-b from-[#0a0a0d] to-[#060608] backdrop-blur-sm border border-stone-900/60 rounded-2xl overflow-hidden transition-all duration-700 hover:border-[#e5c158]/40 hover:shadow-[0_40px_80px_-20px_rgba(0,0,0,0.9),0_0_0_1px_rgba(229,193,88,0.1)_inset] hover:-translate-y-3" data-aos="fade-up" data-aos-delay="{{ $index * 150 }}">
                
                <div class="absolute top-0 left-0 w-full h-[2px] bg-gradient-to-r from-transparent via-[#e5c158]/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                
                <div class="relative overflow-hidden h-[340px] bg-[#050507]">
                    <img src="{{ $item['image'] }}"
                         alt="{{ $item['brand'] }} {{ $item['model'] }}"
                         class="w-full h-full object-cover transition-all duration-1000 group-hover:scale-110">
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent opacity-80 group-hover:opacity-60 transition-opacity duration-700"></div>
                    
                    <div class="absolute inset-0 bg-black/50 backdrop-blur-[3px] opacity-0 group-hover:opacity-100 transition-all duration-500 flex flex-col items-center justify-center gap-4">
                        <button class="relative overflow-hidden px-8 py-3.5 text-[8px] uppercase tracking-[0.25em] font-medium text-stone-200 border border-[#e5c158]/40 rounded-full hover:bg-[#e5c158] hover:text-black transition-all duration-300 group/btn">
                            <span class="relative z-10">View Specs</span>
                            <span class="absolute inset-0 bg-[#e5c158] scale-x-0 group-hover/btn:scale-x-100 transition-transform duration-500 origin-left"></span>
                        </button>
                        <span class="text-[8px] uppercase tracking-[0.3em] text-stone-400 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">Click to inspect masterpiece</span>
                    </div>
                    
                    <div class="absolute top-4 right-4 flex flex-col gap-2">
                        <span class="px-3.5 py-1.5 rounded-full {{ $item['badgeClass'] }} backdrop-blur-sm shadow-lg shadow-black/30">
                            {{ $item['badge'] }}
                        </span>
                    </div>
                    
                    <div class="absolute bottom-4 left-4 flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-all duration-500 delay-150">
                        <button class="w-9 h-9 rounded-full bg-black/60 backdrop-blur-sm border border-stone-800/50 flex items-center justify-center text-stone-400 hover:text-[#e5c158] hover:border-[#e5c158]/30 transition-all duration-300 text-sm hover:scale-110">♡</button>
                        <button class="w-9 h-9 rounded-full bg-black/60 backdrop-blur-sm border border-stone-800/50 flex items-center justify-center text-stone-400 hover:text-[#e5c158] hover:border-[#e5c158]/30 transition-all duration-300 text-sm hover:scale-110">↻</button>
                        <button class="w-9 h-9 rounded-full bg-black/60 backdrop-blur-sm border border-stone-800/50 flex items-center justify-center text-stone-400 hover:text-[#e5c158] hover:border-[#e5c158]/30 transition-all duration-300 text-sm hover:scale-110">⚡</button>
                    </div>
                    
                    <div class="absolute bottom-4 right-4 bg-black/60 backdrop-blur-sm px-4 py-2 rounded-full border border-stone-800/50 group-hover:border-[#e5c158]/20 transition-all duration-300">
                        <span class="text-sm font-semibold text-[#e5c158] tracking-wide">{{ $item['price'] }}</span>
                    </div>
                </div>
                
                <div class="p-6 space-y-3">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-[9px] uppercase tracking-[0.3em] text-stone-500 font-semibold">{{ $item['brand'] }}</span>
                                <span class="w-1 h-1 rounded-full bg-stone-700"></span>
                                <span class="text-[8px] uppercase tracking-[0.15em] text-stone-600">{{ $item['edition'] }}</span>
                            </div>
                            <h3 class="text-lg font-light text-white tracking-wide group-hover:text-[#e5c158] transition-colors duration-500 mt-1">{{ $item['model'] }}</h3>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4 text-[10px] text-stone-500">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-[#e5c158]" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            {{ $item['rating'] }}
                        </span>
                        <span class="w-px h-3 bg-stone-800"></span>
                        <span>{{ $item['specs'] }}</span>
                        <span class="w-px h-3 bg-stone-800"></span>
                        <span class="{{ $item['badge'] === 'Sold Out' ? 'text-red-400/60' : 'text-emerald-400/60' }}">
                            {{ $item['badge'] === 'Sold Out' ? 'Unavailable' : 'In Stock' }}
                        </span>
                    </div>
                    
                    <div class="h-[1px] w-full bg-gradient-to-r from-stone-900/50 to-transparent group-hover:from-[#e5c158]/30 transition-all duration-700"></div>
                    
                    <div class="flex items-center justify-between pt-1">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full {{ $item['badge'] === 'Sold Out' ? 'bg-stone-700/50' : 'bg-emerald-500/60' }} animate-pulse"></span>
                            <span class="text-[8px] uppercase tracking-[0.2em] text-stone-500">{{ $item['stock'] }}</span>
                        </div>
                        @if($item['badge'] === 'Sold Out')
                            <button disabled class="px-6 py-2.5 text-[9px] uppercase tracking-[0.2em] font-semibold border border-stone-800 text-stone-600 bg-stone-950/40 rounded-full cursor-not-allowed">
                                Depleted
                            </button>
                        @else
                            <button class="relative overflow-hidden px-6 py-2.5 text-[9px] uppercase tracking-[0.2em] font-semibold bg-[#e5c158] text-black rounded-full transition-all duration-300 hover:bg-white hover:shadow-[0_0_40px_rgba(229,193,88,0.3)] hover:scale-105 group/btn">
                                <span class="relative z-10 flex items-center gap-2">
                                    Acquire
                                    <svg class="w-3 h-3 transform transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </span>
                                <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-full group-hover/btn:translate-x-full transition-transform duration-700"></span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Bottom CTA -->
        <div class="text-center mt-14" data-aos="fade-up" data-aos-delay="400">
            <a href="#" class="inline-flex items-center gap-3 text-[10px] uppercase tracking-[0.3em] text-stone-500 border border-stone-800/50 px-8 py-3.5 rounded-full hover:border-[#e5c158]/30 hover:text-stone-300 transition-all duration-500 bg-[#0a0a0d]/30 backdrop-blur-sm group">
                <span>Explore the full collection</span>
                <span class="w-5 h-[1px] bg-stone-700 group-hover:bg-[#e5c158]/50 transition-all duration-300"></span>
                <span class="text-[#e5c158]/60 group-hover:translate-x-1 transition-transform duration-300">→</span>
            </a>
        </div>
    </div>
</section>

<!-- ============================================================
     TRUST BUILDING SECTION
     ============================================================ -->
<section class="py-20 md:py-28 bg-[#050507] border-t border-stone-900/60 relative overflow-hidden">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[350px] bg-gradient-to-b from-[#e5c158]/[0.03] to-transparent blur-[140px] pointer-events-none"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
        
        <div class="text-center max-w-2xl mx-auto mb-20" data-aos="fade-up" data-aos-duration="1000">
            <span class="text-[9px] uppercase tracking-[0.5em] text-[#e5c158] font-semibold block bg-[#e5c158]/5 py-1.5 px-4 rounded-full w-fit mx-auto backdrop-blur-md border border-[#e5c158]/10">
                Why Valencia Dial
            </span>
            <h2 class="text-3xl md:text-5xl font-light tracking-widest text-white uppercase mt-4">
                The Hallmarks of <span class="text-[#e5c158]">Trust</span>
            </h2>
            <div class="h-[1px] w-24 bg-gradient-to-r from-transparent via-[#e5c158]/60 to-transparent mx-auto mt-5"></div>
            <p class="text-stone-500 text-[10px] tracking-[0.25em] uppercase mt-4 font-light">Founded on integrity · engineered for true connoisseurs</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 xl:gap-8">
            
            <div class="group relative bg-[#0a0a0d]/40 backdrop-blur-md border border-stone-900/80 rounded-sm p-8 text-center transition-all duration-500 hover:bg-[#0a0a0d] hover:border-[#e5c158]/30 hover:shadow-[0_30px_60px_-15px_rgba(0,0,0,0.9)] hover:-translate-y-1.5"
                 data-aos="fade-up" data-aos-delay="100" data-aos-duration="800">
                <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-[#e5c158]/0 to-transparent group-hover:via-[#e5c158]/40 transition-all duration-700"></div>
                
                <div class="relative flex flex-col items-center">
                    <div class="w-16 h-16 flex items-center justify-center border border-stone-900 bg-[#050507] rounded-full text-stone-400 group-hover:text-[#e5c158] group-hover:border-[#e5c158]/20 transition-all duration-500 mb-6 group-hover:scale-105">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    </div>
                    
                    <h4 class="text-xs uppercase tracking-[0.25em] text-stone-300 font-medium group-hover:text-white transition-colors duration-300">Secure Vault</h4>
                    <div class="h-[1px] w-8 bg-stone-900 my-4 group-hover:w-16 group-hover:bg-[#e5c158]/30 transition-all duration-500"></div>
                    <p class="text-stone-500 text-[11px] font-light leading-relaxed max-w-[200px] group-hover:text-stone-400 transition-colors duration-300">256-bit encryption architecture & fully insured logistical pipelines.</p>
                    
                    <span class="absolute -top-3 -right-3 text-[7px] uppercase tracking-widest text-stone-700 opacity-0 group-hover:opacity-100 transition-opacity duration-500">Secure</span>
                </div>
            </div>

            <div class="group relative bg-[#0a0a0d]/40 backdrop-blur-md border border-stone-900/80 rounded-sm p-8 text-center transition-all duration-500 hover:bg-[#0a0a0d] hover:border-[#e5c158]/30 hover:shadow-[0_30px_60px_-15px_rgba(0,0,0,0.9)] hover:-translate-y-1.5"
                 data-aos="fade-up" data-aos-delay="200" data-aos-duration="800">
                <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-[#e5c158]/0 to-transparent group-hover:via-[#e5c158]/40 transition-all duration-700"></div>
                
                <div class="relative flex flex-col items-center">
                    <div class="w-16 h-16 flex items-center justify-center border border-stone-900 bg-[#050507] rounded-full text-stone-400 group-hover:text-[#e5c158] group-hover:border-[#e5c158]/20 transition-all duration-500 mb-6 group-hover:scale-105">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                    </div>
                    
                    <h4 class="text-xs uppercase tracking-[0.25em] text-stone-300 font-medium group-hover:text-white transition-colors duration-300">Horology Elite</h4>
                    <div class="h-[1px] w-8 bg-stone-900 my-4 group-hover:w-16 group-hover:bg-[#e5c158]/30 transition-all duration-500"></div>
                    <p class="text-stone-500 text-[11px] font-light leading-relaxed max-w-[200px] group-hover:text-stone-400 transition-colors duration-300">Master watchmakers retaining over 50+ years of collective lineage.</p>
                    
                    <span class="absolute -top-3 -right-3 text-[7px] uppercase tracking-widest text-stone-700 opacity-0 group-hover:opacity-100 transition-opacity duration-500">Expertise</span>
                </div>
            </div>

            <div class="group relative bg-[#0a0a0d]/40 backdrop-blur-md border border-stone-900/80 rounded-sm p-8 text-center transition-all duration-500 hover:bg-[#0a0a0d] hover:border-[#e5c158]/30 hover:shadow-[0_30px_60px_-15px_rgba(0,0,0,0.9)] hover:-translate-y-1.5"
                 data-aos="fade-up" data-aos-delay="300" data-aos-duration="800">
                <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-[#e5c158]/0 to-transparent group-hover:via-[#e5c158]/40 transition-all duration-700"></div>
                
                <div class="relative flex flex-col items-center">
                    <div class="w-16 h-16 flex items-center justify-center border border-stone-900 bg-[#050507] rounded-full text-stone-400 group-hover:text-[#e5c158] group-hover:border-[#e5c158]/20 transition-all duration-500 mb-6 group-hover:scale-105">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                    </div>
                    
                    <h4 class="text-xs uppercase tracking-[0.25em] text-stone-300 font-medium group-hover:text-white transition-colors duration-300">Certified Assets</h4>
                    <div class="h-[1px] w-8 bg-stone-900 my-4 group-hover:w-16 group-hover:bg-[#e5c158]/30 transition-all duration-500"></div>
                    <p class="text-stone-500 text-[11px] font-light leading-relaxed max-w-[200px] group-hover:text-stone-400 transition-colors duration-300">Every luxury asset verified, cataloged, and fully serialized.</p>
                    
                    <span class="absolute -top-3 -right-3 text-[7px] uppercase tracking-widest text-stone-700 opacity-0 group-hover:opacity-100 transition-opacity duration-500">Verified</span>
                </div>
            </div>

            <div class="group relative bg-[#0a0a0d]/40 backdrop-blur-md border border-stone-900/80 rounded-sm p-8 text-center transition-all duration-500 hover:bg-[#0a0a0d] hover:border-[#e5c158]/30 hover:shadow-[0_30px_60px_-15px_rgba(0,0,0,0.9)] hover:-translate-y-1.5"
                 data-aos="fade-up" data-aos-delay="400" data-aos-duration="800">
                <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-[#e5c158]/0 to-transparent group-hover:via-[#e5c158]/40 transition-all duration-700"></div>
                
                <div class="relative flex flex-col items-center">
                    <div class="w-16 h-16 flex items-center justify-center border border-stone-900 bg-[#050507] rounded-full text-stone-400 group-hover:text-[#e5c158] group-hover:border-[#e5c158]/20 transition-all duration-500 mb-6 group-hover:scale-105">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                    
                    <h4 class="text-xs uppercase tracking-[0.25em] text-stone-300 font-medium group-hover:text-white transition-colors duration-300">Concierge Care</h4>
                    <div class="h-[1px] w-8 bg-stone-900 my-4 group-hover:w-16 group-hover:bg-[#e5c158]/30 transition-all duration-500"></div>
                    <p class="text-stone-500 text-[11px] font-light leading-relaxed max-w-[200px] group-hover:text-stone-400 transition-colors duration-300">Dedicated private support desk and endless after-sales coverage.</p>
                    
                    <span class="absolute -top-3 -right-3 text-[7px] uppercase tracking-widest text-stone-700 opacity-0 group-hover:opacity-100 transition-opacity duration-500">Premium</span>
                </div>
            </div>

        </div>

        <div class="mt-20 border-t border-stone-900/50 pt-12 flex flex-col lg:flex-row items-center justify-between gap-8"
             data-aos="fade-up" data-aos-offset="50" data-aos-duration="1000">
            <div class="flex items-center gap-6 opacity-60 hover:opacity-100 transition-opacity duration-500 flex-wrap justify-center">
                <span class="text-[9px] uppercase tracking-[0.4em] text-stone-600 font-bold">Featured In</span>
                <div class="flex items-center gap-6 sm:gap-8">
                    <span class="text-stone-400 text-xs font-light tracking-[0.25em] hover:text-[#e5c158] transition-colors duration-300 cursor-default uppercase">Forbes</span>
                    <span class="text-stone-400 text-xs font-light tracking-[0.25em] hover:text-[#e5c158] transition-colors duration-300 cursor-default uppercase">Robb Report</span>
                    <span class="text-stone-400 text-xs font-light tracking-[0.25em] hover:text-[#e5c158] transition-colors duration-300 cursor-default uppercase">Hodinkee</span>
                    <span class="text-stone-400 text-xs font-light tracking-[0.25em] hover:text-[#e5c158] transition-colors duration-300 cursor-default uppercase">Revolution</span>
                </div>
            </div>

            <div class="flex items-center gap-5 text-stone-500 text-xs bg-[#0a0a0d] px-6 py-3 border border-stone-900 rounded-none hover:border-[#e5c158]/20 transition-all duration-300">
                <div class="flex items-center gap-1.5">
                    <span class="text-[#e5c158] text-base leading-none">★</span>
                    <span class="text-stone-300 font-semibold tracking-wide">4.9</span>
                    <span class="text-stone-600 text-[11px]">/ 5.0</span>
                </div>
                <span class="h-4 w-[1px] bg-stone-900"></span>
                <span class="text-stone-400 tracking-wide text-[11px]">120+ Verified Reviews</span>
                <span class="flex items-center gap-1.5 ml-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-[pulse_2s_infinite]"></span>
                    <span class="text-[8px] uppercase tracking-[0.2em] text-emerald-500/70 font-bold">Live</span>
                </span>
            </div>
        </div>

        <div class="mt-10 flex flex-wrap items-center justify-center gap-6 md:gap-10 text-[8px] uppercase tracking-[0.3em] text-stone-600 font-medium"
             data-aos="fade-zoom-in" data-aos-easing="ease-in-back" data-aos-delay="500" data-aos-offset="0">
            <span class="flex items-center gap-2">
                <svg class="w-3 h-3 text-[#e5c158]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="12 2 22 8.5 22 15.5 12 22 2 15.5 2 8.5 12 2"></polygon></svg>
                Industry Sovereign Architecture
            </span>
            <span class="hidden sm:block w-[1px] h-3 bg-stone-900"></span>
            <span class="flex items-center gap-2">
                <svg class="w-3 h-3 text-[#e5c158]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                Guaranteed Authenticity
            </span>
            <span class="hidden sm:block w-[1px] h-3 bg-stone-900"></span>
            <span class="flex items-center gap-2">
                <svg class="w-3 h-3 text-[#e5c158]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                Insured Global Custody
            </span>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Countdown Timer
        let hours = 47;
        let minutes = 19;
        let seconds = 37;

        const hoursEl = document.getElementById('countdown-hours');
        const minutesEl = document.getElementById('countdown-minutes');
        const secondsEl = document.getElementById('countdown-seconds');

        if (hoursEl && minutesEl && secondsEl) {
            setInterval(function() {
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
    });
</script>
@endpush