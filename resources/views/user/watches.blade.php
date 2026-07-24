@extends('layouts.app')

@section('title', 'Watches — Valencia Dial')

@section('content')
<section class="relative min-h-[70vh] flex items-center justify-center overflow-hidden border-b border-white/5 px-4 py-20 md:py-28">
    <div class="relative z-10 max-w-5xl mx-auto text-center space-y-8">
        <div class="flex items-center justify-center space-x-4" data-aos="fade-down" data-aos-delay="200">
            <span class="h-px w-10 sm:w-16 bg-gradient-to-r from-transparent to-white opacity-30"></span>
            <span class="text-gold text-xs tracking-[5px] uppercase font-medium">Horology</span>
            <span class="h-px w-10 sm:w-16 bg-gradient-to-l from-transparent to-white opacity-30"></span>
        </div>
        <h1 class="hero-title font-serif font-bold text-white gold-glow" data-aos="zoom-in" data-aos-delay="300">
            Precision <br class="sm:hidden">
            <span class="gold">Timepieces</span>
        </h1>
        <p class="text-white/40 text-sm sm:text-base max-w-2xl mx-auto font-light leading-relaxed tracking-widest px-2" data-aos="fade-up" data-aos-delay="400">
            Discover our curated collection of exceptional watches — where master craftsmanship meets timeless design.
        </p>
    </div>
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1 opacity-30" data-aos="fade-up" data-aos-delay="600">
        <span class="text-[8px] uppercase tracking-[0.3em] text-white/40">Scroll</span>
        <div class="w-px h-10 bg-gradient-to-b from-white/40 to-transparent"></div>
    </div>
</section>

<section class="py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <form method="GET" action="{{ route('user.watches') }}" class="flex flex-col sm:flex-row gap-4 items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-[0.5rem] uppercase tracking-[0.2em] text-white/40 font-medium">{{ $products->total() }} timepieces</span>
                @if($watchCategory)
                <span class="w-px h-3 bg-white/10"></span>
                <span class="text-[0.5rem] uppercase tracking-[0.2em] text-white/40 font-medium">{{ $watchCategory->name }}</span>
                @endif
            </div>
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <div class="relative flex-1 sm:w-64">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-white/40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search watches..." class="w-full py-3 pl-10 pr-4 bg-[#0a0a0f] border border-white/10 rounded-full text-sm text-white placeholder-white/30 focus:outline-none focus:border-white/30 transition">
                </div>
                <select name="sort" onchange="this.form.submit()" class="py-3 px-4 bg-[#0a0a0f] border border-white/10 rounded-full text-xs text-white uppercase tracking-[0.1em] appearance-none cursor-pointer focus:outline-none focus:border-white/30 transition">
                    <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Latest</option>
                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price ↑</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price ↓</option>
                    <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name A-Z</option>
                    <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Name Z-A</option>
                </select>
            </div>
        </form>
    </div>
</section>

<section class="pb-24 px-4">
    <div class="max-w-7xl mx-auto">
        @if($products->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach($products as $product)
            <div class="bg-card-dark rounded-2xl overflow-hidden card-shadow group relative" data-aos="fade-up">
                <a href="{{ route('user.product.detail', $product) }}" class="block">
                    <div class="relative">
                        @if($product->stock <= 3 && $product->stock > 0)
                        <span class="absolute top-3 left-3 z-20 px-2.5 py-1 text-[9px] font-bold uppercase tracking-widest bg-gradient-to-r from-amber-500/20 to-amber-600/20 text-amber-400 border border-amber-500/20 rounded-full">75% OFF</span>
                        @else
                        <span class="absolute top-3 left-3 z-20 px-2.5 py-1 text-[9px] font-bold uppercase tracking-widest bg-gradient-to-r from-emerald-500/20 to-emerald-600/20 text-emerald-400 border border-emerald-500/20 rounded-full">NEW ARRIVAL</span>
                        @endif
                        <div class="product-img-wrapper relative">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=400&h=400&fit=crop' }}"
                                 alt="{{ $product->name }}" class="w-full h-48 sm:h-56 object-cover transition-opacity duration-700 group-hover:opacity-0" loading="lazy">
                            @if($product->image_secondary)
                            <img src="{{ asset('storage/' . $product->image_secondary) }}"
                                 alt="{{ $product->name }}" class="w-full h-48 sm:h-56 object-cover absolute inset-0 transition-opacity duration-700 opacity-0 group-hover:opacity-100" loading="lazy">
                            @endif
                        </div>
                    </div>
                </a>
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <a href="{{ route('user.product.detail', $product) }}">
                            <h3 class="text-sm font-medium tracking-wide text-white group-hover:gold-hover transition-colors">{{ $product->name }}</h3>
                        </a>
                        <p class="text-[11px] text-white/40 tracking-wider mt-0.5 font-light">{{ $product->category->name ?? 'General' }}</p>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="w-3 h-3 rounded-full bg-[#3b2b52] ring-1 ring-white/10"></span>
                            <span class="w-3 h-3 rounded-full bg-[#1a1a1a] ring-1 ring-white/10"></span>
                        </div>
                        <div class="flex items-center gap-1 mt-2">
                            <span class="text-[10px] text-amber-400/80">★★★★★</span>
                            <span class="text-white/40 text-[11px] ml-1">4.85</span>
                        </div>
                    </div>
                    <div class="mt-5 pt-4 border-t border-white/5 flex items-center justify-between">
                        <span class="text-base font-semibold tracking-wider gold">${{ number_format($product->price, 2) }}</span>
                        <a href="{{ route('user.product.detail', $product) }}" class="btn-gold text-xs py-2.5 px-5">View Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-12">{{ $products->links() }}</div>
        @else
        <div class="text-center py-24">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-white/5 border border-white/10 flex items-center justify-center">
                <svg class="w-6 h-6 text-white/40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-white/40 text-sm">No watches in this collection yet</p>
            <p class="text-[0.625rem] uppercase tracking-[0.2em] text-white/40 mt-2">New timepieces arriving soon</p>
        </div>
        @endif
    </div>
</section>

<section class="py-20 bg-section-alt border-t border-white/5">
    <div class="max-w-3xl mx-auto px-6 text-center" data-aos="fade-up">
        <h2 class="section-title font-serif font-bold text-white">Explore All <span class="gold">Collections</span></h2>
        <p class="text-white/40 text-sm font-light mt-4 max-w-md mx-auto">Browse our full range including acoustic masterpieces.</p>
        <a href="{{ route('user.shop') }}" class="btn-gold px-10 py-3.5 mt-8 inline-block">View All Products</a>
    </div>
</section>
@endsection
