@extends('layouts.app')

@section('title', 'Gallery — Valencia Dial')

@push('styles')
<style>
.gallery-item { position: relative; overflow: hidden; border-radius: 1rem; background: #13131a; border: 1px solid rgba(255,255,255,0.04); cursor: pointer; transition: all 0.5s cubic-bezier(0.16,1,0.3,1); }
.gallery-item:hover { border-color: #d4af37; transform: translateY(-3px); box-shadow: 0 20px 40px rgba(0,0,0,0.5); }
.gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.8s ease; }
.gallery-item:hover img { transform: scale(1.06); }
.gallery-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(10,10,15,0.9) 0%, transparent 50%); opacity: 0; transition: opacity 0.4s ease; }
.gallery-item:hover .gallery-overlay { opacity: 1; }
.gallery-info { position: absolute; bottom: 0; left: 0; right: 0; padding: 1.5rem; transform: translateY(10px); opacity: 0; transition: all 0.4s ease; }
.gallery-item:hover .gallery-info { transform: translateY(0); opacity: 1; }
</style>
@endpush

@section('content')
<section class="relative min-h-[70vh] flex items-center justify-center overflow-hidden border-b px-4 py-20 md:py-28 bg-[#0a0a0f]" style="border-color: rgba(255,255,255,0.04);">
    <div class="relative z-10 max-w-5xl mx-auto text-center space-y-8">
        <div class="flex items-center justify-center space-x-4" data-aos="fade-down" data-aos-delay="200">
            <span class="h-px w-10 sm:w-16 bg-gradient-to-r from-transparent to-[#d4af37] opacity-40"></span>
            <span class="text-[10px] sm:text-xs uppercase tracking-[0.5em] gold font-medium">Visual Archive</span>
            <span class="h-px w-10 sm:w-16 bg-gradient-to-l from-transparent to-[#d4af37] opacity-40"></span>
        </div>
        <h1 class="font-serif text-5xl sm:text-7xl md:text-8xl font-light tracking-[0.12em] text-white/90 uppercase leading-[1.1]" data-aos="zoom-in" data-aos-delay="300">
            The <br class="sm:hidden">
            <span class="font-normal gold">Gallery</span>
        </h1>
        <p class="text-white/40 text-sm sm:text-base max-w-2xl mx-auto font-light leading-relaxed tracking-widest px-2" data-aos="fade-up" data-aos-delay="400">
            A curated visual journey through our collection of exceptional timepieces and acoustic masterpieces.
        </p>
    </div>
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1 opacity-30" data-aos="fade-up" data-aos-delay="600">
        <span class="text-[8px] uppercase tracking-[0.3em] text-white/40">Scroll</span>
        <div class="w-px h-10 bg-gradient-to-b from-[#d4af37] to-transparent"></div>
    </div>
</section>

<section class="py-24 px-4 border-t bg-[#0a0a0f]" style="border-color: rgba(255,255,255,0.04);">
    <div class="max-w-7xl mx-auto">
        @if($products->count())
        <div class="columns-1 sm:columns-2 lg:columns-3 xl:columns-4 gap-4 space-y-4">
            @foreach($products as $product)
            <div class="gallery-item break-inside-avoid" data-aos="fade-up">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy">
                <div class="gallery-overlay"></div>
                <div class="gallery-info">
                    <p class="text-[0.625rem] uppercase tracking-[0.2em] gold font-medium">{{ $product->brand ?? 'Valencia' }}</p>
                    <h3 class="text-sm text-white/90 font-light mt-1">{{ $product->name }}</h3>
                    <p class="text-xs text-white/40 mt-0.5">${{ number_format($product->price, 2) }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-24">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-card-dark border border-white/5 flex items-center justify-center">
                <svg class="w-6 h-6 text-white/40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/></svg>
            </div>
            <p class="text-white/40 text-sm">Gallery is being curated</p>
            <p class="text-[0.625rem] uppercase tracking-[0.2em] text-white/40 mt-2">Upload products with images to populate</p>
        </div>
        @endif
    </div>
</section>

<section class="py-20 bg-[#0a0a0f] border-t" style="border-color: rgba(255,255,255,0.04);">
    <div class="max-w-3xl mx-auto px-6 text-center" data-aos="fade-up">
        <h2 class="font-serif text-3xl md:text-4xl font-light text-white/90">Want to See <span class="gold">More</span>?</h2>
        <p class="text-white/40 text-sm font-light mt-4 max-w-md mx-auto">Visit our shop to explore the full collection with detailed specifications.</p>
        <a href="{{ route('user.shop') }}" class="btn-gold px-10 py-3.5 mt-8">Browse All Products</a>
    </div>
</section>
@endsection
