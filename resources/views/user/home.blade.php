@extends('layouts.app')

@section('title', 'Valencia Dial - The Haute Horology Atelier')

@push('styles')
<style>
:root { 
    --gold: #e5c158; 
    --bg-deep: #050507; 
    --bg-card: #0a0a0d;
    --gold-glow: rgba(229, 193, 88, 0.15);
}
body { background: var(--bg-deep); color: #e4e4e7; }

.luxury-title { font-family: 'Cormorant Garamond', serif; letter-spacing: 0.02em; }

/* ===== BUTTONS ===== */
.btn-primary {
    background: var(--gold);
    color: #050507;
    padding: 0.75rem 2rem;
    font-size: 0.6rem;
    letter-spacing: 0.25em;
    text-transform: uppercase;
    font-weight: 600;
    border: none;
    transition: all 0.3s ease;
    cursor: pointer;
}
.btn-primary:hover {
    background: #d4b047;
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(229, 193, 88, 0.2);
}

.btn-outline {
    background: transparent;
    color: white;
    padding: 0.75rem 2rem;
    font-size: 0.6rem;
    letter-spacing: 0.25em;
    text-transform: uppercase;
    font-weight: 500;
    border: 1px solid rgba(255,255,255,0.08);
    transition: all 0.3s ease;
    cursor: pointer;
}
.btn-outline:hover {
    border-color: var(--gold);
    color: var(--gold);
    background: rgba(229, 193, 88, 0.05);
}

.btn-add-cart {
    background: var(--gold);
    color: #050507;
    padding: 0.6rem 1.5rem;
    font-size: 0.5rem;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    font-weight: 600;
    border: none;
    transition: all 0.3s ease;
    cursor: pointer;
}
.btn-add-cart:hover {
    background: #d4b047;
    transform: scale(1.05);
}

.btn-disabled {
    background: #1a1a1a;
    color: #555;
    padding: 0.6rem 1.5rem;
    font-size: 0.5rem;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    font-weight: 500;
    cursor: not-allowed;
    border: 1px solid #2a2a2a;
}

/* ===== SECTION MARKERS ===== */
.section-marker {
    font-size: 0.55rem;
    letter-spacing: 0.4em;
    text-transform: uppercase;
    color: rgba(229, 193, 88, 0.6);
    font-weight: 500;
    border-left: 2px solid var(--gold);
    padding-left: 14px;
}

.gold-line {
    width: 3rem;
    height: 1px;
    background: rgba(229, 193, 88, 0.35);
}

.gold-divider {
    width: 100%;
    max-width: 12rem;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(229, 193, 88, 0.2), transparent);
    margin: 2rem auto;
}

/* ===== CARDS ===== */


/* ===== CAROUSEL ===== */
.carousel-track {
    display: flex;
    gap: 2rem;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    scroll-behavior: smooth;
    padding: 0.25rem 0.25rem 1rem 0.25rem;
    scrollbar-width: none;
}
.carousel-track::-webkit-scrollbar { display: none; }

.carousel-item {
    flex: 0 0 320px;
    scroll-snap-align: start;
    transition: transform 0.2s ease;
}
@media (min-width: 640px) {
    .carousel-item { flex: 0 0 300px; }
}
@media (min-width: 1024px) {
    .carousel-item { flex: 0 0 340px; }
}

.img-wrapper {
    position: relative;
    width: 100%;
    aspect-ratio: 1/1;
    overflow: hidden;
    background: #0b0b0f;
    border: 1px solid #1c1c22;
    transition: border 0.3s;
}
.group:hover .img-wrapper { border-color: #3a3a44; }

.img-wrapper .primary-img,
.img-wrapper .secondary-img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: opacity 0.6s cubic-bezier(0.25,0.46,0.45,0.94), transform 0.6s ease;
    will-change: transform, opacity;
}
.img-wrapper .primary-img {
    opacity: 1;
    z-index: 2;
    transform: scale(1);
}
.img-wrapper .secondary-img {
    opacity: 0;
    z-index: 1;
    transform: scale(1.05);
}
.group:hover .img-wrapper .primary-img {
    opacity: 0;
    transform: scale(1.1);
}
.group:hover .img-wrapper .secondary-img {
    opacity: 1;
    transform: scale(1);
}

.product-card {
    background: rgba(10,10,13,0.4);
    backdrop-filter: blur(2px);
    border: 1px solid #1b1b22;
    transition: all 0.3s ease;
    padding: 1.5rem;
}
.product-card:hover {
    background: #0f0f14;
    border-color: #3a3a44;
    transform: translateY(-4px);
}

/* ===== BADGES ===== */
.badge-new {
    background: rgba(229, 193, 88, 0.08);
    border: 1px solid rgba(229, 193, 88, 0.2);
    color: #e5c158;
}
.badge-off {
    background: rgba(168, 85, 247, 0.12);
    border: 1px solid rgba(168, 85, 247, 0.2);
    color: #c084fc;
}

.scroll-btn {
    background: #0e0e12;
    border: 1px solid #222;
    color: #aaa;
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 999px;
    transition: 0.2s;
    cursor: pointer;
}
.scroll-btn:hover {
    background: #1a1a1f;
    border-color: #e5c158;
    color: #e5c158;
}

.color-dot {
    display: inline-block;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 1px solid #2a2a30;
    transition: border 0.2s;
    cursor: default;
}
.color-dot:hover { border-color: #e5c158; }

.rating-star { 
    color: #e5c158; 
    font-size: 13px; 
    letter-spacing: 1px;
}

.stat-number {
    font-family: 'Cormorant Garamond', serif;
    font-size: 3.5rem;
    line-height: 1;
    color: var(--gold);
}
@media (max-width: 640px) {
    .stat-number { font-size: 2.5rem; }
}

/* ===== PRODUCT GRID ===== */
.product-grid-card .product-image-wrapper {
    position: relative;
    aspect-ratio: 1/1;
    overflow: hidden;
    background: #050507;
    border: 1px solid #1a1a1a;
    transition: border 0.3s ease;
}
.product-grid-card:hover .product-image-wrapper {
    border-color: rgba(229, 193, 88, 0.3);
}

.product-grid-card .product-image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: opacity 0.5s ease, transform 0.5s ease;
}
.product-grid-card .product-image-wrapper .hover-img {
    position: absolute;
    inset: 0;
    opacity: 0;
}
.product-grid-card:hover .product-image-wrapper .main-img {
    opacity: 0;
    transform: scale(1.05);
}
.product-grid-card:hover .product-image-wrapper .hover-img {
    opacity: 1;
}

.product-grid-card .overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.5);
    opacity: 0;
    transition: opacity 0.4s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}
.product-grid-card:hover .overlay {
    opacity: 1;
}

/* ===== HERO ===== */
.hero-gradient {
    background: radial-gradient(ellipse at 70% 30%, rgba(229, 193, 88, 0.03) 0%, transparent 70%),
                radial-gradient(ellipse at 30% 70%, rgba(229, 193, 88, 0.02) 0%, transparent 60%),
                linear-gradient(180deg, #0a0a0d 0%, #050507 100%);
}
</style>
@endpush

@section('content')

{{-- ============================================================ --}}
{{-- 1. HERO — Full-screen video background, centered content      --}}
{{-- ============================================================ --}}
@php
    $heroVideoUrl = $heroVideo ?? 'https://cdn.coverr.co/videos/coverr-luxury-watch-on-a-marble-surface-5767/1080p.mp4';
    $isYoutube = preg_match('/(youtube\.com|youtu\.be)/', $heroVideoUrl);
    $youtubeId = '';
    if ($isYoutube) {
        preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $heroVideoUrl, $matches);
        $youtubeId = $matches[1] ?? '';
    }
@endphp
<section class="relative h-screen min-h-[600px] flex items-center justify-center overflow-hidden border-b border-stone-900">
    @if($isYoutube && $youtubeId)
    <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}?autoplay=1&mute=1&loop=1&playlist={{ $youtubeId }}&controls=0&showinfo=0&modestbranding=1&iv_load_policy=3&rel=0&background=1"
            class="absolute inset-0 w-full h-full pointer-events-none"
            frameborder="0"
            allow="autoplay; fullscreen"
            allowfullscreen></iframe>
    @else
    <video autoplay muted loop playsinline
           poster="https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=1920&h=1080&fit=crop"
           class="absolute inset-0 w-full h-full object-cover">
        <source src="{{ $heroVideoUrl }}" type="video/mp4">
    </video>
    @endif
    <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/30 to-black/80"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-[#050507]/60 via-transparent to-[#050507]/60"></div>

    <div class="relative z-10 max-w-4xl mx-auto text-center px-6">
        <p class="text-[0.55rem] tracking-[0.45em] uppercase text-[#e5c158]/80 font-medium mb-6" data-aos="fade-down">
            {{ $heroTagline ?? 'Est. 2026' }}
        </p>
        <h1 class="luxury-title text-5xl md:text-7xl lg:text-8xl font-light text-white tracking-[0.06em] uppercase leading-[1.1]" data-aos="fade-up" data-aos-delay="100">
            {{ $heroTitle ?? 'Valencia' }} <span class="text-[#e5c158]">{{ $heroTitleAccent ?? 'Dial' }}</span>
        </h1>
        <div class="gold-divider" data-aos="fade-up" data-aos-delay="200"></div>
        <p class="text-stone-300 text-sm md:text-base font-light max-w-2xl mx-auto leading-relaxed" data-aos="fade-up" data-aos-delay="300">
            {{ $heroSubtitle ?? 'A digital atelier where exceptional craftsmanship meets timeless design.' }}
        </p>
        <div class="flex items-center justify-center gap-4 mt-10 flex-wrap" data-aos="fade-up" data-aos-delay="400">
            <a href="{{ $heroCtaPrimaryLink ?? route('user.shop') }}" class="btn-primary text-xs md:text-sm px-8 py-4">
                {{ $heroCtaPrimaryText ?? 'Explore Collection' }}
            </a>
            <a href="{{ $heroCtaSecondaryLink ?? route('user.register') }}" class="btn-outline text-xs md:text-sm px-8 py-4">
                {{ $heroCtaSecondaryText ?? 'Join the Vault' }}
            </a>
        </div>
    </div>

    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 opacity-40" data-aos="fade-up" data-aos-delay="600">
        <span class="text-[0.45rem] tracking-[0.4em] uppercase text-stone-400">Scroll</span>
        <div class="w-px h-10 bg-gradient-to-b from-[#e5c158] to-transparent"></div>
    </div>
</section>

{{-- ============================================================ --}}
{{-- 2. PRODUCT GRID — Shop the Collection                       --}}
{{-- ============================================================ --}}
<section class="py-20 md:py-28 border-b border-stone-900">
    <div class="max-w-7xl mx-auto px-6">
        <div class="mb-14 text-center" data-aos="fade-up">
            <p class="section-marker inline-block text-left">The Vault</p>
            <h2 class="luxury-title text-3xl md:text-5xl text-white font-light tracking-wide mt-3">Shop the <span class="text-[#e5c158]">Collection</span></h2>
            <div class="gold-line mx-auto mt-4"></div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            @php $cartProducts = $topSellers->merge($featured); @endphp
            @forelse($cartProducts as $product)
            <a href="{{ route('user.product.detail', $product) }}" class="product-card group block" data-aos="fade-up" data-aos-delay="{{ $loop->index * 60 }}">
                <div class="relative p-3">
                    @if($product->stock <= 3 && $product->stock > 0)
                    <span class="absolute top-3 left-3 z-20 px-2.5 py-1 text-[9px] font-bold uppercase tracking-widest badge-off">75% OFF</span>
                    @else
                    <span class="absolute top-3 left-3 z-20 px-2.5 py-1 text-[9px] font-bold uppercase tracking-widest badge-new">NEW ARRIVAL</span>
                    @endif
                    <div class="img-wrapper rounded-sm">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=400&h=400&fit=crop' }}"
                             alt="{{ $product->name }}" class="primary-img" loading="lazy">
                        @if($product->image_secondary)
                        <img src="{{ asset('storage/' . $product->image_secondary) }}"
                             alt="{{ $product->name }}" class="secondary-img" loading="lazy">
                        @endif
                    </div>
                </div>
                <div class="px-3 pb-3 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="text-sm font-medium tracking-wide text-white group-hover:text-[#e5c158] transition-colors truncate">{{ $product->name }}</h3>
                        <p class="text-[11px] text-stone-500 tracking-wider font-light">{{ $product->category->name ?? 'Luxury' }} · +2</p>
                        <div class="flex items-center gap-1 mt-1">
                            <span class="rating-star text-xs">★★★★★</span>
                            <span class="text-stone-400 text-[10px] ml-1">4.85</span>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-stone-950/70 flex items-center justify-between">
                        <span class="text-sm font-semibold tracking-wider text-white">${{ number_format($product->price, 2) }}</span>
                        <form action="{{ route('user.cart.add', $product) }}" method="POST" onclick="event.stopPropagation()">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            @if($product->stock > 0)
                            <button type="submit" class="btn-buy">Buy Now</button>
                            @else
                            <span class="text-[10px] text-stone-600 uppercase tracking-wider">Sold Out</span>
                            @endif
                        </form>
                    </div>
                </div>
            </a>
            @empty
            <p class="col-span-full text-center text-stone-500 py-16">No products available.</p>
            @endforelse
        </div>

        <div class="text-center mt-10" data-aos="fade-up">
            <a href="{{ route('user.shop') }}" class="btn-outline text-sm px-10 py-3">
                Browse Full Collection <span class="ml-2">→</span>
            </a>
        </div>
    </div>
</section>

{{-- ============================================================ --}}
{{-- 3. CATEGORY CAROUSEL                                         --}}
{{-- ============================================================ --}}
<section class="py-16 border-b border-stone-900 bg-[#07070a]">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-10" data-aos="fade-up">
            <p class="section-marker inline-block text-left">Quick Navigation</p>
            <h2 class="luxury-title text-2xl md:text-4xl text-white font-light tracking-wide mt-3">Browse by <span class="text-[#e5c158]">Category</span></h2>
        </div>
        <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16">
            @forelse($categories as $cat)
            <a href="{{ route('user.shop', ['category' => $cat->id]) }}" class="group flex flex-col items-center space-y-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                <div class="w-20 h-20 md:w-24 md:h-24 rounded-full border border-stone-800 bg-[#0a0a0d] p-1 flex items-center justify-center transition-all duration-300 group-hover:border-[#e5c158] group-hover:scale-105 shadow-xl">
                    <div class="w-full h-full rounded-full bg-[#050507] overflow-hidden flex items-center justify-center">
                        @if($cat->image)
                        <img src="{{ asset('storage/' . $cat->image) }}" alt="{{ $cat->name }}" class="w-full h-full object-cover">
                        @else
                        <span class="text-[9px] text-stone-600 tracking-wider uppercase">{{ substr($cat->name, 0, 4) }}</span>
                        @endif
                    </div>
                </div>
                <span class="text-[10px] uppercase tracking-[0.2em] text-stone-400 transition-colors duration-300 group-hover:text-[#e5c158] font-medium">{{ $cat->name }}</span>
            </a>
            @empty
            <p class="text-stone-500 text-xs">No categories available.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- ============================================================ --}}
{{-- 4. STATS BANNER                                              --}}
{{-- ============================================================ --}}
<section class="py-16 md:py-20 border-b border-stone-900">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-12">
            <div class="text-center" data-aos="fade-up">
                <p class="stat-number">{{ $categories->count() }}</p>
                <p class="text-[0.5rem] uppercase tracking-[0.35em] text-stone-500 mt-2">Collections</p>
            </div>
            <div class="text-center" data-aos="fade-up" data-aos-delay="80">
                <p class="stat-number">{{ $topSellers->count() + $featured->count() }}+</p>
                <p class="text-[0.5rem] uppercase tracking-[0.35em] text-stone-500 mt-2">Masterpieces</p>
            </div>
            <div class="text-center" data-aos="fade-up" data-aos-delay="160">
                <p class="stat-number">100%</p>
                <p class="text-[0.5rem] uppercase tracking-[0.35em] text-stone-500 mt-2">Authenticated</p>
            </div>
            <div class="text-center" data-aos="fade-up" data-aos-delay="240">
                <p class="stat-number">24/7</p>
                <p class="text-[0.5rem] uppercase tracking-[0.35em] text-stone-500 mt-2">Concierge</p>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================ --}}
{{-- 5. BEST SELLERS CAROUSEL — Premium Card Design             --}}
{{-- ============================================================ --}}
<section class="w-full max-w-7xl mx-auto border-b border-stone-900/80 pb-12 px-4 md:px-6 py-8 md:py-14">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8 pb-4 border-b border-stone-900/70" data-aos="fade-up">
        <div>
            <p class="section-marker">Most Coveted</p>
            <h2 class="luxury-title text-2xl md:text-4xl text-white font-light tracking-wide mt-3">Best <span class="text-[#e5c158]">Sellers</span></h2>
        </div>
        <a href="{{ route('user.shop') }}" class="text-[11px] uppercase tracking-[0.2em] text-[#e5c158] hover:text-white transition-colors duration-300 flex items-center gap-2">
            View All Matrix <i class="fas fa-arrow-right text-[10px]"></i>
        </a>
    </div>

    <div class="relative">
        <div id="carouselTrack" class="carousel-track">
            @forelse($topSellers as $product)
            <a href="{{ route('user.product.detail', $product) }}" class="carousel-item group product-card flex flex-col transition-all duration-300">
                <div class="relative">
                    @if($product->stock <= 3 && $product->stock > 0)
                    <span class="absolute top-3 left-3 z-20 px-3 py-1.5 text-[10px] font-bold uppercase tracking-widest badge-off">75% OFF</span>
                    @else
                    <span class="absolute top-3 left-3 z-20 px-3 py-1.5 text-[10px] font-bold uppercase tracking-widest badge-new">NEW ARRIVAL</span>
                    @endif
                    <div class="img-wrapper rounded-sm">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=400&h=400&fit=crop&crop=center' }}"
                             alt="{{ $product->name }}"
                             class="primary-img"
                             loading="lazy">
                        @if($product->image_secondary)
                        <img src="{{ asset('storage/' . $product->image_secondary) }}"
                             alt="{{ $product->name }}"
                             class="secondary-img"
                             loading="lazy">
                        @endif
                    </div>
                </div>
                <div class="mt-4 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="text-base font-medium tracking-wide text-white group-hover:text-[#e5c158] transition-colors">{{ $product->name }}</h3>
                        <p class="text-[11px] text-stone-500 tracking-wider mt-0.5 font-light">{{ $product->category->name ?? 'Luxury Collection' }}</p>
                        <div class="flex items-center gap-2 mt-3">
                            <span class="color-dot bg-[#3b2b52]"></span>
                            <span class="color-dot bg-[#1a1a1a]"></span>
                            <span class="color-dot bg-[#8b7355]"></span>
                        </div>
                        <div class="flex items-center gap-1 mt-2">
                            <span class="rating-star">★★★★★</span>
                            <span class="text-stone-400 text-[11px] ml-1">{{ number_format(4.5 + ($loop->index * 0.1), 2) }}</span>
                        </div>
                    </div>
                    <div class="mt-5 pt-4 border-t border-stone-950/70 flex items-center justify-between">
                        <div>
                            <span class="text-base font-semibold tracking-wider text-white">${{ number_format($product->price, 2) }}</span>
                        </div>
                        <form action="{{ route('user.cart.add', $product) }}" method="POST" onclick="event.stopPropagation()">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            @if($product->stock > 0)
                            <button type="submit" class="btn-buy">Buy Now</button>
                            @else
                            <span class="text-[10px] text-stone-600 uppercase tracking-wider">Sold Out</span>
                            @endif
                        </form>
                    </div>
                </div>
            </a>
            @empty
            <p class="text-stone-500 text-xs py-16">No products available yet.</p>
            @endforelse
        </div>

        <div class="flex justify-center gap-4 mt-6 md:mt-8">
            <button id="scrollLeft" class="scroll-btn"><i class="fas fa-chevron-left text-xs"></i></button>
            <button id="scrollRight" class="scroll-btn"><i class="fas fa-chevron-right text-xs"></i></button>
        </div>
    </div>

    <div class="text-stone-600 text-[10px] text-center mt-6 tracking-widest border-t border-stone-900/40 pt-5">
        <i class="fas fa-mouse-pointer mr-2 text-[#e5c158]"></i> Hover over image to switch view · scroll carousel
    </div>
</section>

{{-- ============================================================ --}}
{{-- 6. CINEMATIC VIDEO BANNER                                    --}}
{{-- ============================================================ --}}
<section class="relative my-12 h-[50vh] min-h-[350px] bg-stone-950 flex items-center justify-center overflow-hidden border-y border-stone-900">
    <div class="absolute inset-0 bg-gradient-to-r from-[#050507] via-[#050507]/70 to-[#050507] z-10"></div>
    <div class="absolute inset-0 w-full h-full flex items-center justify-center text-stone-800 select-none">
        <span class="text-7xl font-black uppercase opacity-5 tracking-[0.2em]">VALENCIA LUXURY LABS</span>
    </div>
    <div class="relative z-20 max-w-xl mx-auto text-center px-6 space-y-4" data-aos="fade-up">
        <span class="text-[10px] uppercase tracking-[0.4em] text-[#e5c158] font-bold block">Aesthetic Blueprint</span>
        <h2 class="text-2xl md:text-4xl font-light text-white uppercase tracking-widest luxury-title">Designed for the <span class="text-[#e5c158]">Refined</span></h2>
        <p class="text-xs text-stone-400 font-light tracking-wide leading-relaxed max-w-lg mx-auto">
            Watch our craft manifesto to discover how we process luxury watch elements and acoustic purity configurations.
        </p>
        <a href="{{ route('user.about') }}" class="btn-outline inline-block mt-4">
            Discover More
        </a>
    </div>
</section>

{{-- ============================================================ --}}
{{-- 7. FEATURED TIMEPIECES                                       --}}
{{-- ============================================================ --}}
<section class="py-20 md:py-28 border-b border-stone-900">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-end justify-between mb-14" data-aos="fade-up">
            <div>
                <p class="section-marker">Curated Selection</p>
                <h2 class="luxury-title text-3xl md:text-5xl text-white font-light tracking-wide mt-3">Featured <span class="text-[#e5c158]">Timepieces</span></h2>
            </div>
            <a href="{{ route('user.shop') }}" class="text-[0.5rem] tracking-[0.35em] uppercase text-stone-400 hover:text-[#e5c158] transition-colors hidden md:block">View All →</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($featured as $i => $product)
            <a href="{{ route('user.product.detail', $product) }}" class="product-card group block" data-aos="fade-up" data-aos-delay="{{ $i * 120 }}">
                <div class="relative p-4">
                    @if($product->stock <= 3 && $product->stock > 0)
                    <span class="absolute top-4 left-4 z-20 px-2.5 py-1 text-[9px] font-bold uppercase tracking-widest badge-off">LIMITED</span>
                    @else
                    <span class="absolute top-4 left-4 z-20 px-2.5 py-1 text-[9px] font-bold uppercase tracking-widest badge-new">FEATURED</span>
                    @endif
                    <div class="img-wrapper rounded-sm">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=600&h=600&fit=crop' }}"
                             alt="{{ $product->name }}" class="primary-img" loading="lazy">
                        @if($product->image_secondary)
                        <img src="{{ asset('storage/' . $product->image_secondary) }}"
                             alt="{{ $product->name }}" class="secondary-img" loading="lazy">
                        @endif
                    </div>
                </div>
                <div class="px-4 pb-4 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="text-base font-medium tracking-wide text-white group-hover:text-[#e5c158] transition-colors">{{ $product->name }}</h3>
                        <p class="text-[11px] text-stone-500 tracking-wider mt-0.5 font-light">{{ $product->category->name ?? 'Luxury Collection' }}</p>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="color-dot bg-[#3b2b52]"></span>
                            <span class="color-dot bg-[#1a1a1a]"></span>
                        </div>
                        <div class="flex items-center gap-1 mt-2">
                            <span class="rating-star">★★★★★</span>
                            <span class="text-stone-400 text-[11px] ml-1">{{ number_format(4.5 + ($i * 0.1), 2) }}</span>
                        </div>
                    </div>
                    <div class="mt-5 pt-4 border-t border-stone-950/70 flex items-center justify-between">
                        <span class="text-base font-semibold tracking-wider text-white">${{ number_format($product->price, 2) }}</span>
                        <form action="{{ route('user.cart.add', $product) }}" method="POST" onclick="event.stopPropagation()">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            @if($product->stock > 0)
                            <button type="submit" class="btn-buy">Buy Now</button>
                            @else
                            <span class="text-[10px] text-stone-600 uppercase tracking-wider">Sold Out</span>
                            @endif
                        </form>
                    </div>
                </div>
            </a>
            @empty
            <p class="col-span-full text-center text-stone-500 py-16">No featured products yet.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- ============================================================ --}}
{{-- 8. TRUST SECTION                                              --}}
{{-- ============================================================ --}}
<section class="py-20 md:py-28">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16" data-aos="fade-up">
            <p class="section-marker inline-block text-left">Why Valencia Dial</p>
            <h2 class="luxury-title text-3xl md:text-5xl text-white font-light tracking-wide mt-3">The Hallmarks of <span class="text-[#e5c158]">Trust</span></h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="text-center p-8 border border-white/[0.04] bg-[#0a0a0e]/50" data-aos="fade-up">
                <div class="w-12 h-12 mx-auto mb-5 flex items-center justify-center border border-white/[0.06]">
                    <svg class="w-5 h-5 text-stone-400" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                </div>
                <h4 class="text-[0.55rem] tracking-[0.3em] uppercase text-white font-medium mb-3">Secure Vault</h4>
                <p class="text-stone-500 text-xs font-light leading-relaxed">Encrypted architecture with fully insured logistics.</p>
            </div>
            <div class="text-center p-8 border border-white/[0.04] bg-[#0a0a0e]/50" data-aos="fade-up" data-aos-delay="80">
                <div class="w-12 h-12 mx-auto mb-5 flex items-center justify-center border border-white/[0.06]">
                    <svg class="w-5 h-5 text-stone-400" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <h4 class="text-[0.55rem] tracking-[0.3em] uppercase text-white font-medium mb-3">Expert Curation</h4>
                <p class="text-stone-500 text-xs font-light leading-relaxed">Every piece verified by master horologists.</p>
            </div>
            <div class="text-center p-8 border border-white/[0.04] bg-[#0a0a0e]/50" data-aos="fade-up" data-aos-delay="160">
                <div class="w-12 h-12 mx-auto mb-5 flex items-center justify-center border border-white/[0.06]">
                    <svg class="w-5 h-5 text-stone-400" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <h4 class="text-[0.55rem] tracking-[0.3em] uppercase text-white font-medium mb-3">Certified Assets</h4>
                <p class="text-stone-500 text-xs font-light leading-relaxed">Fully cataloged and serialized authenticity.</p>
            </div>
            <div class="text-center p-8 border border-white/[0.04] bg-[#0a0a0e]/50" data-aos="fade-up" data-aos-delay="240">
                <div class="w-12 h-12 mx-auto mb-5 flex items-center justify-center border border-white/[0.06]">
                    <svg class="w-5 h-5 text-stone-400" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                </div>
                <h4 class="text-[0.55rem] tracking-[0.3em] uppercase text-white font-medium mb-3">Concierge Care</h4>
                <p class="text-stone-500 text-xs font-light leading-relaxed">Private support with lifetime after-sales coverage.</p>
            </div>
        </div>
        <div class="mt-16 text-center" data-aos="fade-up">
            <div class="inline-flex items-center gap-6 px-6 py-3 border border-white/[0.06] text-[0.4rem] tracking-[0.35em] uppercase text-stone-500">
                <span class="flex items-center gap-2">
                    <svg class="w-3 h-3 text-[#e5c158]" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    4.9 / 5.0 — 120+ Verified Reviews
                </span>
                <span class="w-px h-3 bg-white/[0.06]"></span>
                <span class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>Live 24/7 Support</span>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const track = document.getElementById('carouselTrack');
    const leftBtn = document.getElementById('scrollLeft');
    const rightBtn = document.getElementById('scrollRight');
    
    if (track && leftBtn && rightBtn) {
        const scrollAmount = 360;
        leftBtn.addEventListener('click', function() {
            track.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        });
        rightBtn.addEventListener('click', function() {
            track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        });
        
        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') {
                track.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            } else if (e.key === 'ArrowRight') {
                track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        });
    }
});
</script>
@endpush

@endsection