@extends('layouts.app')

@section('title', "{$product->name} — Valencia Dial")

@push('styles')
<style>
.similar-card { background: #0a0a0e; border: 1px solid rgba(255,255,255,0.04); border-radius: 1rem; overflow: hidden; transition: all 0.5s cubic-bezier(0.16,1,0.3,1); }
.similar-card:hover { border-color: rgba(229,193,88,0.2); transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.5); }
</style>
@endpush

@section('content')
<section class="min-h-screen py-16 md:py-24 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center gap-3 text-[0.5rem] uppercase tracking-[0.3em] text-stone-600 mb-10" data-aos="fade-down">
            <a href="{{ route('user.home') }}" class="hover:text-[#e5c158] transition-all">Home</a>
            <span class="text-stone-800">/</span>
            <a href="{{ route('user.shop') }}" class="hover:text-[#e5c158] transition-all">Shop</a>
            <span class="text-stone-800">/</span>
            <span class="text-stone-400">{{ $product->name }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
            <div data-aos="fade-right">
                <div class="relative bg-[#0a0a0e] rounded-2xl overflow-hidden border border-stone-900 group">
                    <div class="aspect-square relative overflow-hidden">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=800&h=800&fit=crop' }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover transition-opacity duration-700 group-hover:opacity-0">
                        @if($product->image_secondary)
                        <img src="{{ asset('storage/' . $product->image_secondary) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover absolute inset-0 transition-opacity duration-700 opacity-0 group-hover:opacity-100">
                        @endif
                    </div>
                    @if($product->stock <= 0)
                    <div class="absolute top-6 left-6">
                        <span class="text-[0.5rem] uppercase tracking-[0.2em] font-semibold px-4 py-2 bg-red-500/10 text-red-400 border border-red-500/20">Out of Stock</span>
                    </div>
                    @elseif($product->stock <= 3)
                    <div class="absolute top-6 left-6">
                        <span class="text-[0.5rem] uppercase tracking-[0.2em] font-semibold px-4 py-2 bg-amber-500/10 text-amber-400 border border-amber-500/20">Only {{ $product->stock }} Left</span>
                    </div>
                    @endif
                    <div class="absolute inset-0 ring-1 ring-inset ring-white/5 rounded-2xl pointer-events-none"></div>
                </div>
            </div>

            <div class="flex flex-col justify-center" data-aos="fade-left">
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <span class="text-[0.5rem] uppercase tracking-[0.3em] text-stone-400 font-medium">{{ $product->brand ?? 'Valencia' }}</span>
                        @if($product->category)
                        <span class="w-px h-3 bg-stone-800"></span>
                        <span class="text-[0.5rem] uppercase tracking-[0.3em] text-[#e5c158]">{{ $product->category->name }}</span>
                        @endif
                    </div>

                    <h1 class="luxury-title text-4xl md:text-5xl font-light text-white tracking-wide leading-tight">
                        {{ $product->name }}
                    </h1>

                    <div class="flex items-baseline gap-4">
                        <span class="text-3xl font-light text-[#e5c158]">${{ number_format($product->price, 2) }}</span>
                        @if($product->stock > 0)
                        <span class="text-[0.5rem] uppercase tracking-[0.2em] text-emerald-500/60 font-medium">
                            <span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                            In Stock ({{ $product->stock }})
                        </span>
                        @else
                        <span class="text-[0.5rem] uppercase tracking-[0.2em] text-red-400/60 font-medium">Out of Stock</span>
                        @endif
                    </div>

                    <div class="w-16 h-px bg-[#e5c158]/40"></div>

                    <div>
                        <p class="text-sm text-stone-400 leading-relaxed">
                            {{ $product->description ?? 'A masterpiece of precision engineering and timeless design. Each detail reflects the unwavering commitment to excellence that defines the Valencia Dial experience.' }}
                        </p>
                    </div>

                    @if($product->stock > 0)
                    <form action="{{ route('user.cart.add', $product) }}" method="POST" class="flex items-center gap-4 pt-4">
                        @csrf
                        <div class="flex items-center gap-3 bg-[#0a0a0e] border border-stone-900 rounded-full px-4 py-2">
                            <button type="button" class="qty-btn" onclick="decrementQty()">−</button>
                            <input type="number" name="quantity" id="qty-input" value="1" min="1" max="{{ $product->stock }}"
                                   class="w-12 text-center bg-transparent text-white text-sm font-light outline-none tabular-nums [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none">
                            <button type="button" class="qty-btn" onclick="incrementQty({{ $product->stock }})">+</button>
                        </div>
                        <button type="submit" class="btn-primary flex-1">Add to Cart</button>
                    </form>
                    @else
                    <button disabled class="btn-primary disabled w-full">Out of Stock</button>
                    @endif

                    <div class="flex items-center gap-6 pt-4 text-[0.4rem] uppercase tracking-[0.3em] text-stone-600">
                        <span class="flex items-center gap-2">
                            <svg class="w-3 h-3 text-emerald-500/60" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            Secure Checkout
                        </span>
                        <span class="flex items-center gap-2">
                            <svg class="w-3 h-3 text-emerald-500/60" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Authentic Guaranteed
                        </span>
                        <span class="flex items-center gap-2">
                            <svg class="w-3 h-3 text-emerald-500/60" fill="currentColor" viewBox="0 0 20 20"><path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/><path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3z"/></svg>
                            Free Shipping
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if($similar->count())
<section class="pb-24 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="mb-12 text-center" data-aos="fade-up">
            <span class="text-[9px] uppercase tracking-[0.5em] text-[#e5c158] font-medium block mb-4">Curated Selection</span>
            <h2 class="luxury-title text-3xl md:text-4xl font-light text-white tracking-wide">
                Complete Your <span class="text-[#e5c158]">Collection</span>
            </h2>
            <div class="w-12 h-px bg-gradient-to-r from-transparent via-[#e5c158] to-transparent mx-auto mt-4"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($similar as $item)
            <a href="{{ route('user.product.detail', $item) }}" class="product-card group block" data-aos="fade-up">
                <div class="relative p-3">
                    <span class="absolute top-3 left-3 z-20 px-2.5 py-1 text-[9px] font-bold uppercase tracking-widest badge-new">SIMILAR</span>
                    <div class="img-wrapper rounded-sm">
                        <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=400&h=400&fit=crop' }}"
                             alt="{{ $item->name }}" class="primary-img" loading="lazy">
                        @if($item->image_secondary)
                        <img src="{{ asset('storage/' . $item->image_secondary) }}"
                             alt="{{ $item->name }}" class="secondary-img" loading="lazy">
                        @endif
                    </div>
                </div>
                <div class="px-3 pb-3 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="text-sm font-medium tracking-wide text-white group-hover:text-[#e5c158] transition-colors">{{ $item->name }}</h3>
                        <p class="text-[11px] text-stone-500 tracking-wider mt-0.5 font-light">{{ $item->category->name ?? 'Luxury' }} · +2</p>
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
                        <span class="text-base font-semibold tracking-wider text-white">${{ number_format($item->price, 2) }}</span>
                        <form action="{{ route('user.cart.add', $item) }}" method="POST" onclick="event.stopPropagation()">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            @if($item->stock > 0)
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
    </div>
</section>
@endif

<script>
    function decrementQty() {
        const input = document.getElementById('qty-input');
        const val = parseInt(input.value) || 1;
        if (val > 1) input.value = val - 1;
    }
    function incrementQty(max) {
        const input = document.getElementById('qty-input');
        const val = parseInt(input.value) || 1;
        if (val < max) input.value = val + 1;
    }
</script>
@endsection
