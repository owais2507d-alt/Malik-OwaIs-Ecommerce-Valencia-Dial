@extends('layouts.app')

@section('title', 'Valencia Dial - The Haute Horology Atelier')

@push('styles')
<style>
:root { --gold: #e5c158; --bg-deep: #050507; --bg-card: #0a0a0d; }
body { background: var(--bg-deep); color: #e4e4e7; }
.luxury-title { font-family: 'Cormorant Garamond', serif; }

.product-minimal { background: var(--bg-card); border: 1px solid rgba(255,255,255,0.04); transition: all 0.6s cubic-bezier(0.16,1,0.3,1); }
.product-minimal:hover { border-color: rgba(229,193,88,0.2); transform: translateY(-4px); }

.feature-card { background: var(--bg-card); border: 1px solid rgba(255,255,255,0.04); transition: all 0.5s ease; }
.feature-card:hover { border-color: rgba(229,193,88,0.12); background: #0d0d12; }

.stat-number { font-family: 'Cormorant Garamond', serif; font-size: 3.5rem; line-height: 1; color: var(--gold); }

.section-marker { font-size: 0.55rem; letter-spacing: 0.4em; text-transform: uppercase; color: rgba(229,193,88,0.6); font-weight: 500; border-left: 2px solid #e5c158; padding-left: 14px; }

.gold-line { width: 3rem; height: 1px; background: rgba(229,193,88,0.35); }
.gold-divider { width: 100%; max-width: 12rem; height: 1px; background: linear-gradient(90deg, transparent, rgba(229,193,88,0.2), transparent); margin: 2rem auto; }

.carousel-track { display: flex; gap: 2rem; overflow-x: auto; scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch; scroll-behavior: smooth; padding: 0.25rem 0.25rem 1rem 0.25rem; scrollbar-width: none; }
.carousel-track::-webkit-scrollbar { display: none; }
.carousel-item { flex: 0 0 280px; scroll-snap-align: start; }
@media (min-width: 640px) { .carousel-item { flex: 0 0 260px; } }
@media (min-width: 1024px) { .carousel-item { flex: 0 0 270px; } }

.img-wrapper { position: relative; width: 100%; aspect-ratio: 1/1; overflow: hidden; background: #0b0b0f; border: 1px solid #1c1c22; transition: border 0.3s; }
.group:hover .img-wrapper { border-color: #3a3a44; }
.img-wrapper .primary-img, .img-wrapper .secondary-img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; transition: opacity 0.6s cubic-bezier(0.25,0.46,0.45,0.94), transform 0.6s ease; will-change: transform, opacity; }
.img-wrapper .primary-img { opacity: 1; z-index: 2; transform: scale(1); }
.img-wrapper .secondary-img { opacity: 0; z-index: 1; transform: scale(1.05); }
.group:hover .img-wrapper .primary-img { opacity: 0; transform: scale(1.1); }
.group:hover .img-wrapper .secondary-img { opacity: 1; transform: scale(1); }

.product-card { background: rgba(10,10,13,0.4); backdrop-filter: blur(2px); border: 1px solid #1b1b22; transition: all 0.3s ease; }
.product-card:hover { background: #0f0f14; border-color: #3a3a44; transform: translateY(-4px); }

.badge-new { background: rgba(229,193,88,0.08); border: 1px solid rgba(229,193,88,0.2); color: #e5c158; }
.badge-off { background: rgba(168,85,247,0.12); border: 1px solid rgba(168,85,247,0.2); color: #c084fc; }

.scroll-btn { background: #0e0e12; border: 1px solid #222; color: #aaa; width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; border-radius: 999px; transition: 0.2s; cursor: pointer; }
.scroll-btn:hover { background: #1a1a1f; border-color: #e5c158; color: #e5c158; }

.color-dot { display: inline-block; width: 14px; height: 14px; border-radius: 50%; border: 1px solid #2a2a30; transition: border 0.2s; cursor: default; }
.color-dot:hover { border-color: #e5c158; }

.btn-buy { background: #7a1f1f; color: white; font-size: 10px; letter-spacing: 0.1em; padding: 0.45rem 1rem; border-radius: 2px; transition: 0.2s; border: none; font-weight: 500; }
.btn-buy:hover { background: #9f2b2b; }

@media (max-width: 640px) { .stat-number { font-size: 2.5rem; } }
</style>
@endpush

@section('content')

{{-- 1. HERO — Split layout: text left, product visual right --}}
<section class="relative min-h-[85vh] flex items-center justify-center border-b border-stone-900 bg-gradient-to-b from-[#0a0a0d] to-[#050507] px-6 overflow-hidden">
    <div class="max-w-7xl w-full grid grid-cols-1 lg:grid-cols-2 gap-12 items-center py-12">
        <div class="space-y-6 text-center lg:text-left" data-aos="fade-right">
            <span class="text-[11px] uppercase tracking-[0.3em] text-[#e5c158] font-semibold">Est. 2026</span>
            <h1 class="text-4xl md:text-7xl font-extralight tracking-widest text-white leading-tight uppercase">
                Valencia <br class="hidden md:block"><span class="font-normal text-[#e5c158]">Dial</span>
            </h1>
            <div class="gold-divider mx-auto lg:mx-0"></div>
            <p class="text-xs md:text-sm text-stone-400 tracking-wider max-w-md mx-auto lg:mx-0 font-light leading-relaxed">
                A digital atelier where exceptional craftsmanship meets timeless design. Luxury audio tech and micro-engineered timepieces forged for modern pioneers.
            </p>
            <div class="pt-4 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                <a href="{{ route('user.shop') }}" class="px-8 py-3 bg-[#e5c158] hover:bg-[#d4b047] text-black text-xs font-semibold tracking-[0.2em] uppercase transition-all duration-300">
                    Explore Collection
                </a>
                @guest
                <a href="{{ route('user.register') }}" class="px-8 py-3 border border-stone-800 hover:border-[#e5c158]/50 text-white text-xs font-medium tracking-[0.2em] uppercase transition-all duration-300 bg-stone-950/40">
                    Join the Vault
                </a>
                @endguest
            </div>
        </div>
        <div class="relative flex justify-center items-center" data-aos="fade-left">
            <div class="absolute w-72 h-72 md:w-96 md:h-96 bg-[#e5c158]/5 rounded-full blur-3xl"></div>
            <div class="relative w-full max-w-md aspect-square bg-[#0a0a0d]/50 border border-stone-900 flex items-center justify-center backdrop-blur-md overflow-hidden">
                <span class="text-[10px] tracking-[0.3em] text-stone-600 uppercase">[Premium Product Close-Up]</span>
            </div>
        </div>
    </div>
</section>

{{-- 2. CART SECTION — Product showcase with add-to-cart --}}
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
            <div class="group" data-aos="fade-up" data-aos-delay="{{ $loop->index * 60 }}">
                <div class="relative aspect-square overflow-hidden bg-[#050507] border border-stone-900 group-hover:border-[#e5c158]/20 transition-all duration-500">
                    <div class="relative w-full h-full overflow-hidden">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=400&h=400&fit=crop' }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover transition-opacity duration-500 group-hover:opacity-0"
                             loading="lazy">
                        @if($product->image_secondary)
                        <img src="{{ asset('storage/' . $product->image_secondary) }}"
                             alt="{{ $product->name }}"
                             class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500 opacity-0 group-hover:opacity-100"
                             loading="lazy">
                        @endif
                    </div>
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-400 flex items-center justify-center">
                        <form action="{{ route('user.cart.add', $product) }}" method="POST" onclick="event.stopPropagation()">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            @if($product->stock > 0)
                            <button type="submit" class="btn-add-cart">Add to Cart</button>
                            @else
                            <span class="btn-disabled">Sold Out</span>
                            @endif
                        </form>
                    </div>
                    @if($product->stock <= 3 && $product->stock > 0)
                    <span class="absolute top-2 right-2 text-[0.35rem] tracking-[0.25em] uppercase px-2 py-1 bg-[#e5c158]/15 text-[#e5c158] border border-[#e5c158]/20">Limited</span>
                    @endif
                </div>
                <div class="pt-3 pb-2">
                    <p class="text-[0.4rem] tracking-[0.3em] uppercase text-stone-500 font-medium">{{ $product->brand ?? 'Valencia' }}</p>
                    <h3 class="text-sm text-white font-light tracking-wide truncate">{{ $product->name }}</h3>
                    <p class="text-sm text-[#e5c158] font-light mt-0.5">${{ number_format($product->price, 2) }}</p>
                </div>
            </div>
            @empty
            <p class="col-span-full text-center text-stone-500 py-16">No products available.</p>
            @endforelse
        </div>

        <div class="text-center mt-10" data-aos="fade-up">
            <a href="{{ route('user.shop') }}" class="btn-outline btn-lg">Browse Full Collection →</a>
        </div>
    </div>
</section>

{{-- 3. QUICK CATEGORY CIRCULAR CAROUSEL --}}
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

{{-- 4. STATS BANNER --}}
<section class="py-16 md:py-20 border-b border-stone-900">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-12">
            <div class="text-center" data-aos="fade-up"><p class="stat-number">{{ $categories->count() }}</p><p class="text-[0.5rem] uppercase tracking-[0.35em] text-stone-500 mt-2">Collections</p></div>
            <div class="text-center" data-aos="fade-up" data-aos-delay="80"><p class="stat-number">{{ $topSellers->count() + $featured->count() }}+</p><p class="text-[0.5rem] uppercase tracking-[0.35em] text-stone-500 mt-2">Masterpieces</p></div>
            <div class="text-center" data-aos="fade-up" data-aos-delay="160"><p class="stat-number">100%</p><p class="text-[0.5rem] uppercase tracking-[0.35em] text-stone-500 mt-2">Authenticated</p></div>
            <div class="text-center" data-aos="fade-up" data-aos-delay="240"><p class="stat-number">24h</p><p class="text-[0.5rem] uppercase tracking-[0.35em] text-stone-500 mt-2">Concierge</p></div>
        </div>
    </div>
</section>

{{-- 5. BEST SELLERS — Horizontal scroll carousel with premium card design --}}
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
            <div class="carousel-item group product-card p-5 flex flex-col transition-all duration-300">
                <div class="relative">
                    @if($product->stock <= 3 && $product->stock > 0)
                    <span class="absolute top-3 left-3 z-20 px-2.5 py-1 text-[9px] font-bold uppercase tracking-widest badge-off">75% OFF</span>
                    @else
                    <span class="absolute top-3 left-3 z-20 px-2.5 py-1 text-[9px] font-bold uppercase tracking-widest badge-new">NEW ARRIVAL</span>
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
                        <h3 class="text-sm font-medium tracking-wide text-white group-hover:text-[#e5c158] transition-colors">{{ $product->name }}</h3>
                        <p class="text-[11px] text-stone-500 tracking-wider mt-0.5 font-light">{{ $product->category->name ?? 'Luxury' }} · +2</p>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="color-dot bg-[#3b2b52]"></span>
                            <span class="color-dot bg-[#1a1a1a]"></span>
                        </div>
                        <div class="flex items-center gap-1 mt-2 text-[#e5c158] text-xs">
                            <span class="rating-star text-[#e5c158] text-xs tracking-wide">★★★★★</span>
                            <span class="text-stone-400 text-[10px] ml-1">4.85</span>
                        </div>
                    </div>
                    <div class="mt-5 pt-4 border-t border-stone-950/70 flex items-center justify-between">
                        <div>
                            <span class="text-sm font-semibold tracking-wider text-white">${{ number_format($product->price, 2) }}</span>
                        </div>
                        <form action="{{ route('user.cart.add', $product) }}" method="POST">
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
            </div>
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

{{-- 6. CINEMATIC VIDEO LOOP BANNER --}}
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
        <a href="{{ route('user.about') }}" class="inline-block mt-4 px-8 py-3 border border-stone-800 hover:border-[#e5c158]/50 text-white text-xs font-medium tracking-[0.2em] uppercase transition-all duration-300">
            Discover More
        </a>
    </div>
</section>

{{-- 7. FEATURED --}}
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
            <div class="feature-card group" data-aos="fade-up" data-aos-delay="{{ $i * 120 }}">
                <div class="relative aspect-square overflow-hidden bg-[#050507]">
                    <div class="relative w-full h-full overflow-hidden">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=600&h=600&fit=crop' }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover transition-opacity duration-500 group-hover:opacity-0"
                             loading="lazy">
                        @if($product->image_secondary)
                        <img src="{{ asset('storage/' . $product->image_secondary) }}"
                             alt="{{ $product->name }}"
                             class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500 opacity-0 group-hover:opacity-100"
                             loading="lazy">
                        @endif
                    </div>
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                        <form action="{{ route('user.cart.add', $product) }}" method="POST">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            @if($product->stock > 0)
                            <button type="submit" class="btn-add-cart">Add to Cart</button>
                            @else
                            <span class="btn-disabled">Sold Out</span>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="p-6 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-[0.45rem] tracking-[0.3em] uppercase text-stone-500">{{ $product->brand ?? 'Valencia' }}</span>
                        <span class="text-xs text-stone-600">{{ $product->category->name ?? 'Collection' }}</span>
                    </div>
                    <h3 class="text-base text-white font-light tracking-wide group-hover:text-[#e5c158] transition-colors">{{ $product->name }}</h3>
                    <div class="gold-line"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-lg text-[#e5c158] font-light">${{ number_format($product->price, 2) }}</span>
                        <span class="text-[0.4rem] tracking-[0.25em] uppercase {{ $product->stock > 0 ? 'text-emerald-500/60' : 'text-red-400/60' }}">{{ $product->stock > 0 ? 'In Stock' : 'Unavailable' }}</span>
                    </div>
                </div>
            </div>
            @empty
            <p class="col-span-full text-center text-stone-500 py-16">No featured products yet.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- 8. TRUST --}}
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
(function() {
    const track = document.getElementById('carouselTrack');
    const leftBtn = document.getElementById('scrollLeft');
    const rightBtn = document.getElementById('scrollRight');
    if (track && leftBtn && rightBtn) {
        const scrollAmount = 320;
        leftBtn.addEventListener('click', () => track.scrollBy({ left: -scrollAmount, behavior: 'smooth' }));
        rightBtn.addEventListener('click', () => track.scrollBy({ left: scrollAmount, behavior: 'smooth' }));
    }
})();
</script>
@endpush

@endsection
