@extends('layouts.app')

@section('title', 'Gallery — Valencia Dial')

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
    .gallery-item { position: relative; overflow: hidden; border-radius: 1rem; background: #0a0a0e; border: 1px solid rgba(255,255,255,0.05); cursor: pointer; transition: all 0.5s ease; }
    .gallery-item:hover { border-color: rgba(212, 175, 55, 0.2); transform: translateY(-3px); box-shadow: 0 20px 40px rgba(0,0,0,0.5); }
    .gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.8s ease; }
    .gallery-item:hover img { transform: scale(1.06); }
    .gallery-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 50%); opacity: 0; transition: opacity 0.4s ease; }
    .gallery-item:hover .gallery-overlay { opacity: 1; }
    .gallery-info { position: absolute; bottom: 0; left: 0; right: 0; padding: 1.5rem; transform: translateY(10px); opacity: 0; transition: all 0.4s ease; }
    .gallery-item:hover .gallery-info { transform: translateY(0); opacity: 1; }
    ::-webkit-scrollbar { width: 4px; background: #0a0a0d; }
    ::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 20px; }
    [data-aos] { pointer-events: none; }
    [data-aos].aos-animate { pointer-events: auto; }
</style>
@endpush

@section('content')

<!-- Hero -->
<section class="relative min-h-[70vh] flex items-center justify-center overflow-hidden border-b border-stone-900/40 bg-gradient-to-b from-[#0a0a0d] via-[#050507] to-[#040405] px-4 py-20 md:py-28">
    <div class="hero-glow"></div>

    <div class="relative z-10 max-w-5xl mx-auto text-center space-y-8">
        <div class="flex items-center justify-center space-x-4" data-aos="fade-down" data-aos-delay="200">
            <span class="h-px w-10 sm:w-16 bg-gradient-to-r from-transparent to-[#e5c158] opacity-60"></span>
            <span class="text-[10px] sm:text-xs uppercase tracking-[0.5em] text-dark-gold font-medium">Visual Archive</span>
            <span class="h-px w-10 sm:w-16 bg-gradient-to-l from-transparent to-[#e5c158] opacity-60"></span>
        </div>

        <h1 class="luxury-title text-5xl sm:text-7xl md:text-8xl font-light tracking-[0.12em] text-stone-200 uppercase leading-[1.1]" data-aos="zoom-in" data-aos-delay="300">
            The <br class="sm:hidden">
            <span class="font-normal text-dark-gold">Gallery</span>
        </h1>

        <p class="text-stone-500 text-sm sm:text-base max-w-2xl mx-auto font-light leading-relaxed tracking-widest px-2" data-aos="fade-up" data-aos-delay="400">
            A curated visual journey through our collection of exceptional timepieces and acoustic masterpieces.
        </p>

        <!-- scroll indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1 opacity-40" data-aos="fade-up" data-aos-delay="600">
            <span class="text-[8px] uppercase tracking-[0.3em] text-stone-500">Scroll</span>
            <div class="w-px h-10 bg-gradient-to-b from-dark-gold to-transparent"></div>
        </div>
    </div>
</section>

<!-- Gallery Grid -->
<section class="py-24 bg-[#040405] border-t border-[rgba(255,255,255,0.04)]">
    <div class="max-w-7xl mx-auto px-6">
        @if($products->count())
        <div class="columns-1 sm:columns-2 lg:columns-3 xl:columns-4 gap-4 space-y-4">
            @foreach($products as $product)
            <div class="gallery-item break-inside-avoid" data-aos="fade-up">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy">
                <div class="gallery-overlay"></div>
                <div class="gallery-info">
                    <p class="text-[0.625rem] uppercase tracking-[0.2em] text-[#d4af37] font-medium">{{ $product->brand ?? 'Valencia' }}</p>
                    <h3 class="text-sm text-white font-light mt-1">{{ $product->name }}</h3>
                    <p class="text-xs text-[#a1a1aa] mt-0.5">${{ number_format($product->price, 2) }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-24">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-[rgba(255,255,255,0.03)] border border-[rgba(255,255,255,0.06)] flex items-center justify-center">
                <svg class="w-6 h-6 text-[#a1a1aa]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/></svg>
            </div>
            <p class="text-[#a1a1aa] text-sm">Gallery is being curated</p>
            <p class="text-[0.625rem] uppercase tracking-[0.2em] text-[#666] mt-2">Upload products with images to populate</p>
        </div>
        @endif
    </div>
</section>

<!-- CTA -->
<section class="py-20 bg-[#060608] border-t border-[rgba(255,255,255,0.04)]">
    <div class="max-w-3xl mx-auto px-6 text-center" data-aos="fade-up">
        <h2 class="font-display text-3xl md:text-4xl font-light text-white">Want to See <span class="text-[#d4af37]">More</span>?</h2>
        <p class="text-[#a1a1aa] text-sm font-light mt-4 max-w-md mx-auto">Visit our shop to explore the full collection with detailed specifications.</p>
        <a href="{{ route('user.shop') }}" class="inline-block mt-8 bg-[#d4af37] hover:bg-white text-black px-8 py-4 rounded-full text-[0.625rem] uppercase tracking-[0.15em] font-medium transition-all">
            Browse All Products
        </a>
    </div>
</section>

@endsection
