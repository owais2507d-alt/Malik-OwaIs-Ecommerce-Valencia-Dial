@extends('layouts.app')
@section('title', 'VALENCIA DIAL – Timeless Elegance')

@section('content')

{{-- 1. FULL-WIDTH CAROUSEL --}}
@include('user.components.carousel')


{{-- 2. DEAL BANNER --}}
@if($activeDeal)
<div class="mt-8 md:mt-12">
    @include('user.components.deal-ticker')
</div>
@else
<div class="mt-16 md:mt-20"></div>
@endif

{{-- 3. SHOP BY CATEGORY --}}
<section class="relative min-h-[50vh] md:min-h-[60vh] flex items-center justify-center overflow-hidden bg-[#0a0a0f]" data-aos="fade-up">
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: repeating-linear-gradient(45deg, #d4af37 0px, #d4af37 1px, transparent 1px, transparent 40px);"></div>
    <div class="relative z-10 w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20 text-center">
        {{-- Section Header --}}
        <div class="mb-14" data-aos="fade-up">
            <span class="text-gold text-xs tracking-[5px] uppercase font-medium">Collections</span>
            <h2 class="section-title font-serif font-bold text-white mt-3">SHOP BY CATEGORY</h2>
            <div class="deco-line"></div>
            <p class="text-white/50 text-sm mt-3 font-light">Discover our curated collections</p>
        </div>

        {{-- Category Grid --}}
        <div class="flex flex-wrap justify-center gap-5">
            @forelse($categories as $cat)
            <a href="{{ route('user.shop', ['category' => $cat->id]) }}"
               class="category-card group block w-[calc(50%-0.625rem)] sm:w-[calc(33.33%-0.875rem)] lg:w-[calc(25%-0.9375rem)]"
               data-aos="fade-up">
                <div class="aspect-square overflow-hidden rounded-xl">
                    <img src="{{ $cat->image ? asset('storage/' . $cat->image) : 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=600&h=600&fit=crop&q=80' }}"
                         alt="{{ $cat->name }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 bg-[#121217]" />
                </div>
                <div class="category-overlay">
                    <h4 class="text-lg font-serif font-bold text-white">{{ $cat->name }}</h4>
                    <p class="text-gold text-sm font-light">{{ $cat->products_count ?? 0 }} Products</p>
                </div>
            </a>
            @empty
            <p class="w-full text-center text-white/40 py-16">Categories coming soon.</p>
            @endforelse
        </div>
<br>

        {{-- View All Button --}}
        <div class="mt-14" data-aos="fade-up">
            <a href="{{ route('user.shop') }}" class="btn-premium inline-flex items-center justify-center gap-3 px-8 py-4 text-sm font-semibold tracking-wider uppercase min-h-[52px]">
                <span>VIEW ALL</span> <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
    </div>
    <BR>
</section>
{{-- SECTION DIVIDER --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="h-px bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
</div>

{{-- 4. BEST SELLERS --}}
<section class="relative min-h-[50vh] md:min-h-[60vh] flex items-center justify-center overflow-hidden bg-[#0a0a0f]" data-aos="fade-up">
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: repeating-linear-gradient(45deg, #d4af37 0px, #d4af37 1px, transparent 1px, transparent 40px);"></div>
    <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 md:pt-20 pb-24 text-center">
        <div class="mb-14" data-aos="fade-up">
            <span class="text-gold text-xs tracking-[5px] uppercase font-medium">Popular</span>
            <h2 class="section-title font-serif font-bold text-white mt-3">BEST SELLERS</h2>
            <div class="deco-line"></div>
            <p class="text-white/50 text-sm mt-3 font-light">Our most coveted timepieces, loved by collectors worldwide.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
            @forelse($topSellers as $product)
            <div class="group" data-aos="fade-up">
                <div class="bg-[#121217] rounded-xl border border-white/5 hover:border-gold/30 transition-all duration-500 shadow-xl shadow-black/20 hover:shadow-gold/10 hover:-translate-y-1.5 p-4">
                    <a href="{{ route('user.product.detail', $product) }}" class="block">
                        <div class="bg-[#0a0a0f] rounded-lg p-3">
                            <div class="aspect-square relative overflow-hidden">
                                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=880&h=880&fit=crop&q=80' }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-contain transition-all duration-700 ease-in-out group-hover:scale-105 bg-[#121217]" />
                                @if($product->image_secondary)
                                <img src="{{ asset('storage/' . $product->image_secondary) }}"
                                     alt="{{ $product->name }}"
                                     class="absolute inset-0 w-full h-full object-contain transition-all duration-700 ease-in-out opacity-0 group-hover:opacity-100 group-hover:scale-105 bg-[#121217]" />
                                @endif
                            </div>
                        </div>
                    </a>

                    <div class="px-1 pb-1 mt-3 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-gold/80 text-[10px] font-medium tracking-wide uppercase">{{ $product->category->name ?? $product->brand ?? 'Collection' }}</span>
                            @if($product->stock > 0)
                            <span class="flex items-center gap-1 text-emerald-500/60 text-[10px]">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                In Stock
                            </span>
                            @else
                            <span class="text-red-400/60 text-[10px]">Sold Out</span>
                            @endif
                        </div>

                        <a href="{{ route('user.product.detail', $product) }}">
                            <h4 class="font-serif text-base font-bold text-white group-hover:gold transition leading-snug text-left">{{ $product->name }}</h4>
                        </a>

                        <div class="flex items-center gap-2 text-white/50 text-[10px]">
                            <i class="fas fa-star text-gold text-[10px]"></i>
                            <span>4.9</span>
                            <span class="w-px h-3 bg-white/10"></span>
                            <span>{{ $product->brand ?? 'Luxury' }}</span>
                            <span class="w-px h-3 bg-white/10"></span>
                            <span class="text-gold/60">{{ $product->stock }} sold</span>
                        </div>

                        <div class="flex items-center justify-between border-t border-white/5 pt-4 mt-3">
                            <span class="text-gold font-bold text-lg">${{ number_format($product->price, 0) }}</span>
                            <a href="{{ route('user.product.detail', $product) }}"
                               class="inline-flex items-center gap-1.5 bg-gold hover:bg-gold/90 text-black font-bold border border-gold px-5 py-2 rounded-full text-[10px] uppercase tracking-wider transition-all duration-300 shadow-lg shadow-gold/20 hover:shadow-gold/30 hover:scale-105 active:scale-95">
                                <span>Buy Now</span>
                                <i class="fas fa-arrow-right text-[9px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <p class="w-full col-span-full text-center text-white/40 py-16">No best sellers yet.</p>
            @endforelse
        </div>
    </div>
</section>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
    <div class="h-px bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
</div>

{{-- 5. VIDEO SECTION --}}
<section class="relative min-h-[500px] md:min-h-[650px] w-full overflow-hidden bg-[#0a0a0f] flex items-center justify-center" data-aos="fade">
    <div class="absolute inset-0 w-full h-full">
        @if($videoSectionFile)
        <video class="absolute inset-0 w-full h-full object-cover pointer-events-none" autoplay muted loop playsinline>
            <source src="{{ asset('storage/' . $videoSectionFile) }}" type="video/mp4">
        </video>
        @elseif($videoSectionUrl)
        <iframe src="{{ $videoSectionUrl }}?autoplay=1&mute=1&loop=1&controls=0&showinfo=0&rel=0&modestbranding=1"
                class="absolute inset-0 w-full h-full pointer-events-none"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
        </iframe>
        @else
        <div class="absolute inset-0 flex items-center justify-center bg-card-dark">
            <div class="text-center">
                <div class="w-20 h-20 mx-auto mb-6 rounded-full border border-white/10 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white/40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z"/></svg>
                </div>
                <p class="text-white/40 text-sm font-light">{{ $videoSectionSubtitle ?? 'Video coming soon' }}</p>
            </div>
        </div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-b from-[#0a0a0f]/60 via-transparent to-[#0a0a0f]/80"></div>
    </div>
    <div class="relative z-10 text-center px-4 max-w-3xl mx-auto" data-aos="fade-up">
        <span class="text-gold text-xs tracking-[5px] uppercase font-medium">{{ $videoSectionSubtitle ?? 'Watch' }}</span>
        <h2 class="font-serif font-bold text-white text-4xl md:text-5xl lg:text-6xl leading-tight mt-3">{{ $videoSectionTitle ?? 'THE CRAFT BEHIND THE CRAFT' }}</h2>
        <div class="deco-line"></div>
        <p class="text-white/50 text-sm mt-3 font-light max-w-lg mx-auto">{{ $videoSectionDescription ?? 'Witness the artistry of master horologists at work — where every second is a masterpiece in the making.' }}</p>
    </div>
</section>

{{-- SECTION DIVIDER --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="h-px bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
</div>

{{-- 6. BUILT ON TRUST --}}
<section class="relative min-h-[50vh] md:min-h-[60vh] flex items-center justify-center overflow-hidden bg-[#0a0a0f]" data-aos="fade-up">
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: repeating-linear-gradient(45deg, #d4af37 0px, #d4af37 1px, transparent 1px, transparent 40px);"></div>
    <div class="relative z-10 w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20 text-center">
        <div class="mb-16" data-aos="fade-up">
            <span class="text-gold text-xs tracking-[5px] uppercase font-medium">Why Choose Us</span>
            <h2 class="section-title font-serif font-bold text-white mt-3">BUILT ON TRUST</h2>
            <div class="deco-line"></div>
            <p class="text-white/50 text-sm mt-3 font-light max-w-xl mx-auto">Decades of excellence, thousands of satisfied collectors — discover why Valencia Dial is the choice of discerning horology enthusiasts worldwide.</p>
        </div>

        <div class="flex flex-wrap justify-center gap-6" data-aos="fade-up">
            <div class="bg-[#121217] border border-white/10 hover:border-[#C5A85C]/50 rounded-2xl p-8 text-center transition-all duration-300 hover:-translate-y-2 group flex flex-col items-center justify-start min-h-[300px] shadow-2xl w-full sm:w-[calc(50%-0.75rem)] lg:w-[calc(25%-1.125rem)]" data-aos="fade-up" data-aos-delay="0">
                <div class="w-16 h-16 rounded-2xl bg-[#C5A85C]/10 text-[#C5A85C] flex items-center justify-center text-2xl mb-6 group-hover:bg-[#C5A85C] group-hover:text-black transition-all duration-300">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h4 class="text-white font-serif font-semibold text-lg mb-3">Authenticity Guaranteed</h4>
                <p class="text-white/50 text-sm leading-relaxed">Every timepiece is verified by master horologists with original papers and serial registration.</p>
            </div>
            <div class="bg-[#121217] border border-white/10 hover:border-[#C5A85C]/50 rounded-2xl p-8 text-center transition-all duration-300 hover:-translate-y-2 group flex flex-col items-center justify-start min-h-[300px] shadow-2xl w-full sm:w-[calc(50%-0.75rem)] lg:w-[calc(25%-1.125rem)]" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 rounded-2xl bg-[#C5A85C]/10 text-[#C5A85C] flex items-center justify-center text-2xl mb-6 group-hover:bg-[#C5A85C] group-hover:text-black transition-all duration-300">
                    <i class="fas fa-truck"></i>
                </div>
                <h4 class="text-white font-serif font-semibold text-lg mb-3">Insured Worldwide Shipping</h4>
                <p class="text-white/50 text-sm leading-relaxed">Fully tracked, insured delivery with white-glove unboxing. Complimentary on orders above $5,000.</p>
            </div>
            <div class="bg-[#121217] border border-white/10 hover:border-[#C5A85C]/50 rounded-2xl p-8 text-center transition-all duration-300 hover:-translate-y-2 group flex flex-col items-center justify-start min-h-[300px] shadow-2xl w-full sm:w-[calc(50%-0.75rem)] lg:w-[calc(25%-1.125rem)]" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 rounded-2xl bg-[#C5A85C]/10 text-[#C5A85C] flex items-center justify-center text-2xl mb-6 group-hover:bg-[#C5A85C] group-hover:text-black transition-all duration-300">
                    <i class="fas fa-undo-alt"></i>
                </div>
                <h4 class="text-white font-serif font-semibold text-lg mb-3">30-Day Returns</h4>
                <p class="text-white/50 text-sm leading-relaxed">Hassle-free returns within 30 days of delivery. No questions asked — your satisfaction is our priority.</p>
            </div>
            <div class="bg-[#121217] border border-white/10 hover:border-[#C5A85C]/50 rounded-2xl p-8 text-center transition-all duration-300 hover:-translate-y-2 group flex flex-col items-center justify-start min-h-[300px] shadow-2xl w-full sm:w-[calc(50%-0.75rem)] lg:w-[calc(25%-1.125rem)]" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 rounded-2xl bg-[#C5A85C]/10 text-[#C5A85C] flex items-center justify-center text-2xl mb-6 group-hover:bg-[#C5A85C] group-hover:text-black transition-all duration-300">
                    <i class="fas fa-star"></i>
                </div>
                <h4 class="text-white font-serif font-semibold text-lg mb-3">VIP Concierge</h4>
                <p class="text-white/50 text-sm leading-relaxed">Dedicated personal assistant for every client. From selection to after-sales, we're with you at every step.</p>
            </div>
         
        </div>
    </div>
</section>

@endsection