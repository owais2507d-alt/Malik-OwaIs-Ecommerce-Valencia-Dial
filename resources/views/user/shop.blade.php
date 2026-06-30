@extends('layouts.app')

@section('title', 'Shop — Valencia Dial')

@push('styles')
<style>
    :root {
        --gold: #d4af37;
        --gold-light: #e5c158;
        --bg-dark: #040405;
    }
    body { background: var(--bg-dark); color: #f5f5f7; font-family: 'Inter', sans-serif; -webkit-font-smoothing: antialiased; }
    .font-display { font-family: 'Playfair Display', serif; }
    .text-gradient-gold { background: linear-gradient(135deg, #d4af37, #f5e6b0, #d4af37); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    .section-label { display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.625rem; letter-spacing: 0.3em; text-transform: uppercase; color: var(--gold-light); font-weight: 500; }
    .section-label::before { content: ''; width: 1.5rem; height: 1px; background: rgba(212, 175, 55, 0.4); }
    .product-card { background: #0a0a0e; border: 1px solid rgba(255,255,255,0.05); border-radius: 1rem; overflow: hidden; transition: all 0.4s ease; }
    .product-card:hover { border-color: rgba(212, 175, 55, 0.2); transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.5); }
    .product-card img { transition: transform 0.7s ease; }
    .product-card:hover img { transform: scale(1.05); }
    .filter-btn { padding: 0.5rem 1.25rem; border-radius: 999px; font-size: 0.625rem; letter-spacing: 0.15em; text-transform: uppercase; font-weight: 500; transition: all 0.3s ease; cursor: pointer; }
    .filter-btn.active { background: #d4af37; color: #0a0a0d; border-color: #d4af37; }
    .filter-btn:not(.active) { background: transparent; color: #a1a1aa; border: 1px solid rgba(255,255,255,0.1); }
    .filter-btn:not(.active):hover { border-color: rgba(212, 175, 55, 0.3); color: #d4af37; }
    .search-input { width: 100%; padding: 0.75rem 1rem 0.75rem 2.5rem; background: #0a0a0e; border: 1px solid rgba(255,255,255,0.08); border-radius: 999px; color: #f5f5f7; font-size: 0.85rem; outline: none; transition: all 0.3s ease; }
    .search-input:focus { border-color: rgba(212, 175, 55, 0.3); background: #111; }
    .search-input::placeholder { color: #666; }
    select { padding: 0.75rem 1rem; background: #0a0a0e; border: 1px solid rgba(255,255,255,0.08); border-radius: 999px; color: #f5f5f7; font-size: 0.75rem; outline: none; text-transform: uppercase; letter-spacing: 0.1em; appearance: none; cursor: pointer; }
    select:focus { border-color: rgba(212, 175, 55, 0.3); }
    ::-webkit-scrollbar { width: 4px; background: #0a0a0d; }
    ::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 20px; }
    [data-aos] { pointer-events: none; }
    [data-aos].aos-animate { pointer-events: auto; }
    .pagination { display: flex; justify-content: center; gap: 0.5rem; margin-top: 3rem; }
    .pagination a, .pagination span { padding: 0.5rem 1rem; border-radius: 999px; font-size: 0.8rem; transition: all 0.3s ease; }
    .pagination a { color: #a1a1aa; border: 1px solid rgba(255,255,255,0.08); text-decoration: none; }
    .pagination a:hover { border-color: rgba(212, 175, 55, 0.3); color: #d4af37; }
    .pagination span:first-child, .pagination span:last-child { display: none; }
    .pagination .active span { background: #d4af37; color: #0a0a0d; border-color: #d4af37; }
</style>
@endpush

@section('content')

<!-- Header -->
<section class="relative min-h-[70vh] flex items-center justify-center overflow-hidden border-b border-stone-900/40 bg-gradient-to-b from-[#0a0a0d] via-[#050507] to-[#040405] px-4 py-20 md:py-28">
    <div class="hero-glow"></div>

    <div class="relative z-10 max-w-5xl mx-auto text-center space-y-8">
        <div class="flex items-center justify-center space-x-4" data-aos="fade-down" data-aos-delay="200">
            <span class="h-px w-10 sm:w-16 bg-gradient-to-r from-transparent to-[#e5c158] opacity-60"></span>
            <span class="text-[10px] sm:text-xs uppercase tracking-[0.5em] text-dark-gold font-medium">The Vault</span>
            <span class="h-px w-10 sm:w-16 bg-gradient-to-l from-transparent to-[#e5c158] opacity-60"></span>
        </div>

        <h1 class="luxury-title text-5xl sm:text-7xl md:text-8xl font-light tracking-[0.12em] text-stone-200 uppercase leading-[1.1]" data-aos="zoom-in" data-aos-delay="300">
            Browse <br class="sm:hidden">
            <span class="font-normal text-dark-gold">Collection</span>
        </h1>

        <p class="text-stone-500 text-sm sm:text-base max-w-2xl mx-auto font-light leading-relaxed tracking-widest px-2" data-aos="fade-up" data-aos-delay="400">
            Discover exceptional timepieces and audio masterpieces curated for the discerning collector.
        </p>

        <!-- scroll indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1 opacity-40" data-aos="fade-up" data-aos-delay="600">
            <span class="text-[8px] uppercase tracking-[0.3em] text-stone-500">Scroll</span>
            <div class="w-px h-10 bg-gradient-to-b from-dark-gold to-transparent"></div>
        </div>
    </div>
</section>

<!-- Filters -->
<section class="pb-8 px-4">
    <div class="max-w-7xl mx-auto">
        <form method="GET" action="{{ route('user.shop') }}" class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('user.shop') }}" class="filter-btn {{ !request('category') ? 'active' : '' }}">All</a>
                @foreach($categories as $cat)
                    <a href="{{ route('user.shop', ['category' => $cat->id, 'search' => request('search'), 'sort' => request('sort')]) }}"
                       class="filter-btn {{ request('category') == $cat->id ? 'active' : '' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <div class="relative flex-1 md:w-64">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#666]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="search-input">
                </div>
                <select name="sort" onchange="this.form.submit()">
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

<!-- Products Grid -->
<section class="pb-24 px-4">
    <div class="max-w-7xl mx-auto">
        @if($products->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach($products as $product)
            <div class="product-card group" data-aos="fade-up">
                <div class="relative aspect-square overflow-hidden bg-[#050507]">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=400&h=400&fit=crop' }}"
                         alt="{{ $product->name }}" class="w-full h-full object-cover" loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-400"></div>
                    <div class="absolute bottom-3 right-3 opacity-0 group-hover:opacity-100 transition-all duration-400 translate-y-2 group-hover:translate-y-0">
                        <span class="bg-[#d4af37] text-black text-[0.5rem] uppercase tracking-[0.15em] font-semibold px-3 py-1.5 rounded-full">Quick View</span>
                    </div>
                </div>
                <div class="p-5 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-[0.5rem] uppercase tracking-[0.2em] text-[#a1a1aa] font-medium">{{ $product->brand ?? 'Valencia' }}</span>
                        <span class="text-xs font-medium text-[#d4af37]">${{ number_format($product->price, 2) }}</span>
                    </div>
                    <h3 class="text-sm font-light text-white tracking-wide">{{ $product->name }}</h3>
                    <div class="flex items-center gap-2 text-[0.5rem] text-[#666] uppercase tracking-[0.15em]">
                        <span>{{ $product->category->name ?? 'General' }}</span>
                        <span class="w-px h-3 bg-[rgba(255,255,255,0.06)]"></span>
                        <span class="{{ $product->stock > 0 ? 'text-emerald-500/60' : 'text-red-400/60' }}">
                            {{ $product->stock > 0 ? $product->stock . ' in stock' : 'Out of stock' }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-12">
            {{ $products->links() }}
        </div>
        @else
        <div class="text-center py-24">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-[rgba(255,255,255,0.03)] border border-[rgba(255,255,255,0.06)] flex items-center justify-center">
                <svg class="w-6 h-6 text-[#a1a1aa]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
            </div>
            <p class="text-[#a1a1aa] text-sm">No products found</p>
            <p class="text-[0.625rem] uppercase tracking-[0.2em] text-[#666] mt-2">Try adjusting your search or filters</p>
        </div>
        @endif
    </div>
</section>

@endsection
