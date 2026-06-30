@extends('layouts.app')

@section('title', 'About — Valencia Dial')

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
    .value-card { background: rgba(10,10,14,0.4); border: 1px solid rgba(255,255,255,0.05); border-radius: 1rem; padding: 2rem; transition: all 0.3s ease; }
    .value-card:hover { border-color: rgba(212, 175, 55, 0.15); background: rgba(10,10,14,0.7); transform: translateY(-2px); }
    .team-img { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(212, 175, 55, 0.2); }
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
            <span class="text-[10px] sm:text-xs uppercase tracking-[0.5em] text-dark-gold font-medium">Our Story</span>
            <span class="h-px w-10 sm:w-16 bg-gradient-to-l from-transparent to-[#e5c158] opacity-60"></span>
        </div>

        <h1 class="luxury-title text-5xl sm:text-7xl md:text-8xl font-light tracking-[0.12em] text-stone-200 uppercase leading-[1.1]" data-aos="zoom-in" data-aos-delay="300">
            Crafting <br class="sm:hidden">
            <span class="font-normal text-dark-gold">Legacy</span>
        </h1>

        <p class="text-stone-500 text-sm sm:text-base max-w-2xl mx-auto font-light leading-relaxed tracking-widest px-2" data-aos="fade-up" data-aos-delay="400">
            Valencia Dial was born from a singular vision — to create the world's most discerning atelier for horology and acoustic masterpieces.
        </p>

        <!-- scroll indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1 opacity-40" data-aos="fade-up" data-aos-delay="600">
            <span class="text-[8px] uppercase tracking-[0.3em] text-stone-500">Scroll</span>
            <div class="w-px h-10 bg-gradient-to-b from-dark-gold to-transparent"></div>
        </div>
    </div>
</section>

<!-- Story -->
<section class="py-24 bg-[#040405] border-t border-[rgba(255,255,255,0.04)]">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div data-aos="fade-right">
                <span class="section-label">Philosophy</span>
                <h2 class="font-display text-3xl md:text-4xl font-light text-white mt-4 leading-tight">Where Precision<br>Meets <span class="text-[#d4af37]">Passion</span></h2>
                <div class="h-px w-16 bg-[#d4af37]/40 mt-6"></div>
                <p class="text-[#a1a1aa] text-sm font-light leading-relaxed mt-6">
                    Founded in 2026, Valencia Dial emerged from a deep appreciation for the art of fine watchmaking and acoustic engineering.
                    We curate only the most exceptional pieces — timepieces that represent the pinnacle of mechanical ingenuity and
                    audio devices that redefine sound.
                </p>
                <p class="text-[#a1a1aa] text-sm font-light leading-relaxed mt-4">
                    Every piece in our collection undergoes rigorous authentication. We partner with master horologists,
                    independent watchmakers, and acoustic engineers to bring you creations that transcend mere utility —
                    they become part of your story.
                </p>
            </div>
            <div class="grid grid-cols-2 gap-4" data-aos="fade-left">
                <div class="aspect-square rounded-xl overflow-hidden bg-[#0a0a0e] border border-[rgba(255,255,255,0.05)]">
                    <img src="https://images.unsplash.com/photo-1614164185128-e4ec99c2c2e4?w=400&h=400&fit=crop" class="w-full h-full object-cover" alt="Craft">
                </div>
                <div class="aspect-square rounded-xl overflow-hidden bg-[#0a0a0e] border border-[rgba(255,255,255,0.05)] mt-8">
                    <img src="https://images.unsplash.com/photo-1612817159949-195730092b5e?w=400&h=400&fit=crop" class="w-full h-full object-cover" alt="Watch detail">
                </div>
                <div class="aspect-square rounded-xl overflow-hidden bg-[#0a0a0e] border border-[rgba(255,255,255,0.05)] -mt-8">
                    <img src="https://images.unsplash.com/photo-1523170335258-f5ed11844a49?w=400&h=400&fit=crop" class="w-full h-full object-cover" alt="Mechanism">
                </div>
                <div class="aspect-square rounded-xl overflow-hidden bg-[#0a0a0e] border border-[rgba(255,255,255,0.05)]">
                    <img src="https://images.unsplash.com/photo-1587836374828-4dbafa94cf0e?w=400&h=400&fit=crop" class="w-full h-full object-cover" alt="Luxury watch">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats -->
<section class="py-20 bg-[#060608] border-y border-[rgba(255,255,255,0.04)]">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-10 md:gap-16">
            <div class="text-center" data-aos="fade-up">
                <span class="font-display text-4xl md:text-5xl text-[#d4af37] font-light">{{ $productCount }}</span>
                <p class="text-[0.625rem] uppercase tracking-[0.3em] text-[#a1a1aa] mt-2">Crafted Assets</p>
            </div>
            <div class="text-center" data-aos="fade-up" data-aos-delay="80">
                <span class="font-display text-4xl md:text-5xl text-[#d4af37] font-light">{{ $categoryCount }}</span>
                <p class="text-[0.625rem] uppercase tracking-[0.3em] text-[#a1a1aa] mt-2">Collections</p>
            </div>
            <div class="text-center" data-aos="fade-up" data-aos-delay="160">
                <span class="font-display text-4xl md:text-5xl text-[#d4af37] font-light">{{ $stockCount }}</span>
                <p class="text-[0.625rem] uppercase tracking-[0.3em] text-[#a1a1aa] mt-2">Items in Vault</p>
            </div>
            <div class="text-center" data-aos="fade-up" data-aos-delay="240">
                <span class="font-display text-4xl md:text-5xl text-[#d4af37] font-light">100</span>
                <p class="text-[0.625rem] uppercase tracking-[0.3em] text-[#a1a1aa] mt-2">% Authenticity</p>
            </div>
        </div>
    </div>
</section>

<!-- Values -->
<section class="py-24 bg-[#040405]">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-16" data-aos="fade-up">
            <span class="section-label justify-center">Our Values</span>
            <h2 class="font-display text-3xl md:text-4xl font-light text-white mt-4">What We Stand <span class="text-[#d4af37]">For</span></h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="value-card" data-aos="fade-up">
                <div class="w-12 h-12 rounded-full bg-[rgba(212,175,55,0.08)] border border-[rgba(212,175,55,0.1)] flex items-center justify-center mb-5">
                    <svg class="w-5 h-5 text-[#d4af37]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="text-sm uppercase tracking-[0.2em] text-white font-medium mb-3">Authenticity</h3>
                <p class="text-[#a1a1aa] text-sm font-light leading-relaxed">Every piece is meticulously verified, cataloged, and certified by master horologists before reaching our vault.</p>
            </div>
            <div class="value-card" data-aos="fade-up" data-aos-delay="80">
                <div class="w-12 h-12 rounded-full bg-[rgba(212,175,55,0.08)] border border-[rgba(212,175,55,0.1)] flex items-center justify-center mb-5">
                    <svg class="w-5 h-5 text-[#d4af37]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-sm uppercase tracking-[0.2em] text-white font-medium mb-3">Heritage</h3>
                <p class="text-[#a1a1aa] text-sm font-light leading-relaxed">We honor the traditions of fine watchmaking while embracing innovation that pushes the craft forward.</p>
            </div>
            <div class="value-card" data-aos="fade-up" data-aos-delay="160">
                <div class="w-12 h-12 rounded-full bg-[rgba(212,175,55,0.08)] border border-[rgba(212,175,55,0.1)] flex items-center justify-center mb-5">
                    <svg class="w-5 h-5 text-[#d4af37]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <h3 class="text-sm uppercase tracking-[0.2em] text-white font-medium mb-3">Concierge</h3>
                <p class="text-[#a1a1aa] text-sm font-light leading-relaxed">Private consultations, white-glove delivery, and lifelong after-sales care for every collector.</p>
            </div>
        </div>
    </div>
</section>

<!-- Team -->
<section class="py-24 bg-[#060608] border-t border-[rgba(255,255,255,0.04)]">
    <div class="max-w-4xl mx-auto px-6 text-center" data-aos="fade-up">
        <span class="section-label justify-center">Leadership</span>
        <h2 class="font-display text-3xl md:text-4xl font-light text-white mt-4">The <span class="text-[#d4af37]">Curators</span></h2>
        <p class="text-[#a1a1aa] text-sm font-light max-w-lg mx-auto mt-4">A collective of master horologists, acoustic engineers, and luxury connoisseurs united by a passion for excellence.</p>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mt-12">
            <div>
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&h=200&fit=crop" class="team-img mx-auto" alt="Founder">
                <h4 class="text-sm text-white font-medium mt-4">Marcus Dial</h4>
                <p class="text-[0.625rem] uppercase tracking-[0.2em] text-[#a1a1aa] mt-1">Founder & Curator</p>
            </div>
            <div>
                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=200&h=200&fit=crop" class="team-img mx-auto" alt="Director">
                <h4 class="text-sm text-white font-medium mt-4">Elena Voss</h4>
                <p class="text-[0.625rem] uppercase tracking-[0.2em] text-[#a1a1aa] mt-1">Head of Horology</p>
            </div>
            <div>
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=200&h=200&fit=crop" class="team-img mx-auto" alt="Engineer">
                <h4 class="text-sm text-white font-medium mt-4">Liam Croft</h4>
                <p class="text-[0.625rem] uppercase tracking-[0.2em] text-[#a1a1aa] mt-1">Acoustic Engineer</p>
            </div>
            <div>
                <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=200&h=200&fit=crop" class="team-img mx-auto" alt="Concierge">
                <h4 class="text-sm text-white font-medium mt-4">Sofia Reyes</h4>
                <p class="text-[0.625rem] uppercase tracking-[0.2em] text-[#a1a1aa] mt-1">Client Concierge</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-20 bg-[#040405] border-t border-[rgba(255,255,255,0.04)]">
    <div class="max-w-3xl mx-auto px-6 text-center" data-aos="fade-up">
        <h2 class="font-display text-3xl md:text-4xl font-light text-white">Begin Your <span class="text-[#d4af37]">Collection</span></h2>
        <p class="text-[#a1a1aa] text-sm font-light mt-4 max-w-md mx-auto">Visit our atelier or browse the virtual vault.</p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mt-8">
            <a href="{{ route('user.shop') }}" class="bg-[#d4af37] hover:bg-white text-black px-8 py-4 rounded-full text-[0.625rem] uppercase tracking-[0.15em] font-medium transition-all">
                Browse Collection
            </a>
            <a href="{{ route('user.contact') }}" class="border border-[rgba(255,255,255,0.1)] hover:border-[#d4af37]/30 text-white px-8 py-4 rounded-full text-[0.625rem] uppercase tracking-[0.15em] font-medium transition-all">
                Contact Us
            </a>
        </div>
    </div>
</section>

@endsection
