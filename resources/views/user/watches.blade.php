@extends('layouts.app')

@section('title', 'Watches — Valencia Dial')

@push('styles')
<style>
body { background: #040405; color: #f5f5f7; }
.product-card { background: #0a0a0e; border: 1px solid rgba(255,255,255,0.04); border-radius: 1rem; overflow: hidden; transition: all 0.5s cubic-bezier(0.16,1,0.3,1); }
.product-card:hover { border-color: rgba(212,175,55,0.2); transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.5); }
.search-input { width: 100%; padding: 0.75rem 1rem 0.75rem 2.5rem; background: #0a0a0e; border: 1px solid rgba(255,255,255,0.08); border-radius: 999px; color: #f5f5f7; font-size: 0.85rem; outline: none; transition: all 0.3s ease; }
.search-input:focus { border-color: rgba(212,175,55,0.3); background: #111; }
.search-input::placeholder { color: #666; }
select { padding: 0.75rem 1rem; background: #0a0a0e; border: 1px solid rgba(255,255,255,0.08); border-radius: 999px; color: #f5f5f7; font-size: 0.75rem; outline: none; text-transform: uppercase; letter-spacing: 0.1em; appearance: none; cursor: pointer; }
select:focus { border-color: rgba(212,175,55,0.3); }
::-webkit-scrollbar { width: 4px; background: #0a0a0d; }
::-webkit-scrollbar-thumb { background: #d4af37; border-radius: 20px; }
</style>
@endpush

@section('content')
<section class="relative min-h-[70vh] flex items-center justify-center overflow-hidden border-b border-[rgba(255,255,255,0.04)] bg-gradient-to-b from-[#0a0a0d] via-[#050507] to-[#040405] px-4 py-20 md:py-28">
    <div class="relative z-10 max-w-5xl mx-auto text-center space-y-8">
        <div class="flex items-center justify-center space-x-4" data-aos="fade-down" data-aos-delay="200">
            <span class="h-px w-10 sm:w-16 bg-gradient-to-r from-transparent to-[#d4af37] opacity-40"></span>
            <span class="text-[10px] sm:text-xs uppercase tracking-[0.5em] text-[#d4af37] font-medium">Horology</span>
            <span class="h-px w-10 sm:w-16 bg-gradient-to-l from-transparent to-[#d4af37] opacity-40"></span>
        </div>
        <h1 class="luxury-title text-5xl sm:text-7xl md:text-8xl font-light tracking-[0.12em] text-white uppercase leading-[1.1]" data-aos="zoom-in" data-aos-delay="300">
            Precision <br class="sm:hidden">
            <span class="font-normal text-[#d4af37]">Timepieces</span>
        </h1>
        <p class="text-[#666] text-sm sm:text-base max-w-2xl mx-auto font-light leading-relaxed tracking-widest px-2" data-aos="fade-up" data-aos-delay="400">
            Discover our curated collection of exceptional watches — where master craftsmanship meets timeless design.
        </p>
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1 opacity-30" data-aos="fade-up" data-aos-delay="600">
            <span class="text-[8px] uppercase tracking-[0.3em] text-[#666]">Scroll</span>
            <div class="w-px h-10 bg-gradient-to-b from-[#d4af37] to-transparent"></div>
        </div>
    </div>
</section>

<section class="py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <form method="GET" action="{{ route('user.watches') }}" class="flex flex-col sm:flex-row gap-4 items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-[0.5rem] uppercase tracking-[0.2em] text-[#666] font-medium">{{ $products->total() }} timepieces</span>
                @if($watchCategory)
                <span class="w-px h-3 bg-[rgba(255,255,255,0.04)]"></span>
                <span class="text-[0.5rem] uppercase tracking-[0.2em] text-[#d4af37] font-medium">{{ $watchCategory->name }}</span>
                @endif
            </div>
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <div class="relative flex-1 sm:w-64">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#666]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search watches..." class="search-input">
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

<section class="pb-24 px-4">
    <div class="max-w-7xl mx-auto">
        @if($products->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach($products as $product)
            <a href="{{ route('user.product.detail', $product) }}" class="product-card group block" data-aos="fade-up">
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
                        <h3 class="text-sm font-medium tracking-wide text-white group-hover:text-[#e5c158] transition-colors">{{ $product->name }}</h3>
                        <p class="text-[11px] text-stone-500 tracking-wider mt-0.5 font-light">{{ $product->category->name ?? 'General' }} · +2</p>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="color-dot bg-[#3b2b52]"></span>
                            <span class="color-dot bg-[#1a1a1a]"></span>
                        </div>
                        <div class="flex items-center gap-1 mt-2">
                            <span class="rating-star">★★★★★</span>
                            <span class="text-stone-400 text-[11px] ml-1">4.85</span>
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
            @endforeach
        </div>
        <div class="mt-12">{{ $products->links() }}</div>
        @else
        <div class="text-center py-24">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-[rgba(255,255,255,0.03)] border border-[rgba(255,255,255,0.04)] flex items-center justify-center">
                <svg class="w-6 h-6 text-[#a1a1aa]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-[#a1a1aa] text-sm">No watches in this collection yet</p>
            <p class="text-[0.625rem] uppercase tracking-[0.2em] text-[#666] mt-2">New timepieces arriving soon</p>
        </div>
        @endif
    </div>
</section>

<section class="py-20 bg-[#060608] border-t border-[rgba(255,255,255,0.04)]">
    <div class="max-w-3xl mx-auto px-6 text-center" data-aos="fade-up">
        <h2 class="luxury-title text-3xl md:text-4xl font-light text-white">Explore All <span class="text-[#e5c158]">Collections</span></h2>
        <p class="text-[#a1a1aa] text-sm font-light mt-4 max-w-md mx-auto">Browse our full range including acoustic masterpieces.</p>
        <a href="{{ route('user.shop') }}" class="btn-primary mt-8">View All Products</a>
    </div>
</section>
@endsection
