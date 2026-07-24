@extends('layouts.app')

@section('title', "{$product->name} — Valencia Dial")

@section('content')
<section class="min-h-screen py-16 md:py-24 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center gap-3 text-[0.5rem] uppercase tracking-[0.3em] text-white/40 mb-10" data-aos="fade-down">
            <a href="{{ route('user.home') }}" class="hover:text-white transition-all">Home</a>
            <span class="text-white/20">/</span>
            <a href="{{ route('user.shop') }}" class="hover:text-white transition-all">Shop</a>
            <span class="text-white/20">/</span>
            <span class="text-white/40">{{ $product->name }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
            <div data-aos="fade-right">
                <div class="bg-card-dark rounded-2xl overflow-hidden group relative">
                    <div class="product-img-wrapper relative">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=800&h=800&fit=crop' }}"
                             alt="{{ $product->name }}"
                             class="w-full aspect-square object-cover transition-opacity duration-700 group-hover:opacity-0">
                        @if($product->image_secondary)
                        <img src="{{ asset('storage/' . $product->image_secondary) }}"
                             alt="{{ $product->name }}"
                             class="w-full aspect-square object-cover absolute inset-0 transition-opacity duration-700 opacity-0 group-hover:opacity-100">
                        @endif
                    </div>
                    @if($product->stock <= 0)
                    <div class="absolute top-6 left-6">
                        <span class="text-[0.5rem] uppercase tracking-[0.2em] font-semibold px-4 py-2 bg-red-500/10 text-red-400 border border-red-500/20 rounded-full">Out of Stock</span>
                    </div>
                    @elseif($product->stock <= 3)
                    <div class="absolute top-6 left-6">
                        <span class="text-[0.5rem] uppercase tracking-[0.2em] font-semibold px-4 py-2 bg-amber-500/10 text-amber-400 border border-amber-500/20 rounded-full">Only {{ $product->stock }} Left</span>
                    </div>
                    @endif
                    <div class="absolute inset-0 ring-1 ring-inset ring-white/5 rounded-2xl pointer-events-none"></div>
                </div>
            </div>

            <div class="flex flex-col justify-center" data-aos="fade-left">
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <span class="text-[0.5rem] uppercase tracking-[0.3em] text-white/40 font-medium">{{ $product->brand ?? 'Valencia' }}</span>
                        @if($product->category)
                        <span class="w-px h-3 bg-white/10"></span>
                        <span class="text-[0.5rem] uppercase tracking-[0.3em] text-white/40">{{ $product->category->name }}</span>
                        @endif
                    </div>

                    <h1 class="hero-title font-serif font-bold text-white">
                        {{ $product->name }}
                    </h1>

                    <div class="flex items-baseline gap-4">
                        <span class="text-3xl font-light gold">${{ number_format($product->price, 2) }}</span>
                        @if($product->stock > 0)
                        <span class="text-[0.5rem] uppercase tracking-[0.2em] text-emerald-500/60 font-medium">
                            <span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                            In Stock ({{ $product->stock }})
                        </span>
                        @else
                        <span class="text-[0.5rem] uppercase tracking-[0.2em] text-red-400/60 font-medium">Out of Stock</span>
                        @endif
                    </div>

                    <div class="deco-line !mx-0"></div>

                    <div>
                        <p class="text-sm text-white/40 leading-relaxed">
                            {{ $product->description ?? 'A masterpiece of precision engineering and timeless design. Each detail reflects the unwavering commitment to excellence that defines the Valencia Dial experience.' }}
                        </p>
                    </div>

                    <div class="pt-4">
                        <span class="text-[10px] uppercase tracking-[0.2em] text-white/40">Inquire about this piece</span>
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
            <span class="text-gold text-xs tracking-[5px] uppercase font-medium block mb-4">Curated Selection</span>
            <h2 class="section-title font-serif font-bold text-white">
                Complete The <span class="gold">Look</span>
            </h2>
            <div class="deco-line"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($similar as $item)
            <div class="bg-card-dark rounded-2xl overflow-hidden card-shadow group relative" data-aos="fade-up">
                <a href="{{ route('user.product.detail', $item) }}" class="block">
                    <div class="relative">
                        <span class="absolute top-3 left-3 z-20 px-2.5 py-1 text-[9px] font-bold uppercase tracking-widest bg-gradient-to-r from-purple-500/20 to-purple-600/20 text-purple-400 border border-purple-500/20 rounded-full">SIMILAR</span>
                        <div class="product-img-wrapper relative aspect-square">
                            <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=600&h=600&fit=crop' }}"
                                 alt="{{ $item->name }}" class="w-full h-full object-cover transition-opacity duration-700 group-hover:opacity-0" loading="lazy">
                            @if($item->image_secondary)
                            <img src="{{ asset('storage/' . $item->image_secondary) }}"
                                 alt="{{ $item->name }}" class="w-full h-full object-cover absolute inset-0 transition-opacity duration-700 opacity-0 group-hover:opacity-100" loading="lazy">
                            @endif
                        </div>
                    </div>
                </a>
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <a href="{{ route('user.product.detail', $item) }}">
                            <h3 class="text-sm font-medium tracking-wide text-white group-hover:gold-hover transition-colors">{{ $item->name }}</h3>
                        </a>
                        <p class="text-[11px] text-white/40 tracking-wider mt-0.5 font-light">{{ $item->category->name ?? 'Luxury' }}</p>
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
                        <span class="text-base font-semibold tracking-wider gold">${{ number_format($item->price, 2) }}</span>
                        <a href="{{ route('user.product.detail', $item) }}" class="text-[10px] uppercase tracking-wider text-white/40 hover:text-gold transition">View Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
