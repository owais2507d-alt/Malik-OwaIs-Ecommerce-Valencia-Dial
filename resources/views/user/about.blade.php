@extends('layouts.app')

@section('content')

<section class="relative min-h-[70vh] flex items-center justify-center overflow-hidden px-4 py-20 md:py-28 bg-[#0a0a0f]" data-aos="fade-up">
    <div class="relative z-10 max-w-5xl mx-auto text-center space-y-8">
        <div class="flex items-center justify-center gap-3">
            <span class="w-6 h-px gold-bg"></span>
            <span class="text-[10px] uppercase tracking-[0.3em] gold font-medium">Our Story</span>
        </div>
        <h1 class="font-serif text-5xl sm:text-7xl md:text-8xl font-light tracking-[0.12em] text-white/90 uppercase leading-[1.1]">
            Crafting <span class="gold">Legacy</span>
        </h1>
        <p class="text-white/40 text-sm sm:text-base max-w-2xl mx-auto font-light leading-relaxed tracking-widest">Valencia Dial was born from a singular vision — to create the world's most discerning atelier for horology and acoustic masterpieces.</p>
        <div class="flex flex-col items-center gap-1 opacity-40 pt-8">
            <span class="text-[8px] uppercase tracking-[0.3em] text-white/40">Scroll</span>
            <div class="w-px h-10 bg-gradient-to-b from-[#d4af37] to-transparent"></div>
        </div>
    </div>
</section>

<section class="py-24 bg-[#0a0a0f]">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="text-center lg:text-left" data-aos="fade-up">
                <div class="flex items-center justify-center lg:justify-start gap-3">
                    <span class="w-6 h-px gold-bg"></span>
                    <span class="text-[10px] uppercase tracking-[0.3em] gold font-medium">Philosophy</span>
                </div>
                <h2 class="font-serif text-3xl md:text-4xl font-light text-white/90 mt-4 leading-tight">Where Precision Meets <span class="gold">Passion</span></h2>
                <div class="w-12 h-px gold-bg my-6"></div>
                <p class="text-white/40 text-sm font-light leading-relaxed">Founded in 2026, Valencia Dial emerged from a deep appreciation for the art of fine watchmaking and acoustic engineering. We curate only the most exceptional pieces — timepieces that represent the pinnacle of mechanical ingenuity and audio devices that redefine sound.</p>
                <p class="text-white/40 text-sm font-light leading-relaxed mt-4">Every piece in our collection undergoes rigorous authentication. We partner with master horologists, independent watchmakers, and acoustic engineers to bring you creations that transcend mere utility — they become part of your story.</p>
            </div>
            <div class="grid grid-cols-2 gap-4" data-aos="fade-up">
                <div class="aspect-square rounded-xl overflow-hidden bg-card-dark">
                    <img src="https://images.unsplash.com/photo-1614164185128-e4ec99c2c2e4?w=400&h=400&fit=crop" class="w-full h-full object-cover" alt="Craft">
                </div>
                <div class="aspect-square rounded-xl overflow-hidden bg-card-dark mt-8">
                    <img src="https://images.unsplash.com/photo-1612817159949-195730092b5e?w=400&h=400&fit=crop" class="w-full h-full object-cover" alt="Watch detail">
                </div>
                <div class="aspect-square rounded-xl overflow-hidden bg-card-dark -mt-8">
                    <img src="https://images.unsplash.com/photo-1523170335258-f5ed11844a49?w=400&h=400&fit=crop" class="w-full h-full object-cover" alt="Mechanism">
                </div>
                <div class="aspect-square rounded-xl overflow-hidden bg-card-dark">
                    <img src="https://images.unsplash.com/photo-1587836374828-4dbafa94cf0e?w=400&h=400&fit=crop" class="w-full h-full object-cover" alt="Luxury watch">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-[#0a0a0f] border-y" style="border-color: rgba(255,255,255,0.03);">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-10 md:gap-16">
            <div class="text-center" data-aos="fade-up">
                <div class="font-serif text-5xl md:text-6xl font-light gold leading-none">{{ $productCount }}</div>
                <p class="text-[0.625rem] uppercase tracking-[0.3em] text-white/40 mt-2">Crafted Assets</p>
            </div>
            <div class="text-center" data-aos="fade-up" data-aos-delay="80">
                <div class="font-serif text-5xl md:text-6xl font-light gold leading-none">{{ $categoryCount }}</div>
                <p class="text-[0.625rem] uppercase tracking-[0.3em] text-white/40 mt-2">Collections</p>
            </div>
            <div class="text-center" data-aos="fade-up" data-aos-delay="160">
                <div class="font-serif text-5xl md:text-6xl font-light gold leading-none">{{ $stockCount }}</div>
                <p class="text-[0.625rem] uppercase tracking-[0.3em] text-white/40 mt-2">Items in Vault</p>
            </div>
            <div class="text-center" data-aos="fade-up" data-aos-delay="240">
                <div class="font-serif text-5xl md:text-6xl font-light gold leading-none">100</div>
                <p class="text-[0.625rem] uppercase tracking-[0.3em] text-white/40 mt-2">% Authenticity</p>
            </div>
        </div>
    </div>
</section>

<section class="py-24 bg-[#0a0a0f]">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-16" data-aos="fade-up">
            <div class="flex items-center justify-center gap-3">
                <span class="w-6 h-px gold-bg"></span>
                <span class="text-[10px] uppercase tracking-[0.3em] gold font-medium">Our Values</span>
            </div>
            <h2 class="font-serif text-3xl md:text-4xl font-light text-white/90 mt-4">What We Stand <span class="gold">For</span></h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-card-dark rounded-xl p-8 smooth-transition hover:-translate-y-1 hover:border-gold/30" style="border-color: rgba(255,255,255,0.04);" data-aos="fade-up">
                <div class="w-12 h-12 rounded-full gold-bg/10 border border-gold/20 flex items-center justify-center mb-5">
                    <svg class="w-5 h-5 gold" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="text-sm uppercase tracking-[0.2em] text-white/90 font-medium mb-3">Authenticity</h3>
                <p class="text-white/40 text-sm font-light leading-relaxed">Every piece is meticulously verified, cataloged, and certified by master horologists before reaching our vault.</p>
            </div>
            <div class="bg-card-dark rounded-xl p-8 smooth-transition hover:-translate-y-1 hover:border-gold/30" style="border-color: rgba(255,255,255,0.04);" data-aos="fade-up" data-aos-delay="80">
                <div class="w-12 h-12 rounded-full gold-bg/10 border border-gold/20 flex items-center justify-center mb-5">
                    <svg class="w-5 h-5 gold" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-sm uppercase tracking-[0.2em] text-white/90 font-medium mb-3">Heritage</h3>
                <p class="text-white/40 text-sm font-light leading-relaxed">We honor the traditions of fine watchmaking while embracing innovation that pushes the craft forward.</p>
            </div>
            <div class="bg-card-dark rounded-xl p-8 smooth-transition hover:-translate-y-1 hover:border-gold/30" style="border-color: rgba(255,255,255,0.04);" data-aos="fade-up" data-aos-delay="160">
                <div class="w-12 h-12 rounded-full gold-bg/10 border border-gold/20 flex items-center justify-center mb-5">
                    <svg class="w-5 h-5 gold" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <h3 class="text-sm uppercase tracking-[0.2em] text-white/90 font-medium mb-3">Concierge</h3>
                <p class="text-white/40 text-sm font-light leading-relaxed">Private consultations, white-glove delivery, and lifelong after-sales care for every collector.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-24 bg-[#0a0a0f] border-t" style="border-color: rgba(255,255,255,0.03);">
    <div class="max-w-4xl mx-auto px-6 text-center" data-aos="fade-up">
        <div class="flex items-center justify-center gap-3">
            <span class="w-6 h-px gold-bg"></span>
            <span class="text-[10px] uppercase tracking-[0.3em] gold font-medium">Leadership</span>
        </div>
        <h2 class="font-serif text-3xl md:text-4xl font-light text-white/90 mt-4">The <span class="gold">Curators</span></h2>
        <p class="text-white/40 text-sm font-light max-w-lg mx-auto mt-4">A collective of master horologists, acoustic engineers, and luxury connoisseurs united by a passion for excellence.</p>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mt-12">
            <div data-aos="fade-up">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&h=200&fit=crop" class="w-24 h-24 rounded-full object-cover mx-auto border-2 border-white/10 hover:border-gold hover:scale-105 transition-all duration-500" alt="Founder">
                <h4 class="text-sm text-white/90 font-medium mt-4">Marcus Dial</h4>
                <p class="text-[0.625rem] uppercase tracking-[0.2em] text-white/40 mt-1">Founder & Curator</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="80">
                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=200&h=200&fit=crop" class="w-24 h-24 rounded-full object-cover mx-auto border-2 border-white/10 hover:border-gold hover:scale-105 transition-all duration-500" alt="Director">
                <h4 class="text-sm text-white/90 font-medium mt-4">Elena Voss</h4>
                <p class="text-[0.625rem] uppercase tracking-[0.2em] text-white/40 mt-1">Head of Horology</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="160">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=200&h=200&fit=crop" class="w-24 h-24 rounded-full object-cover mx-auto border-2 border-white/10 hover:border-gold hover:scale-105 transition-all duration-500" alt="Engineer">
                <h4 class="text-sm text-white/90 font-medium mt-4">Liam Croft</h4>
                <p class="text-[0.625rem] uppercase tracking-[0.2em] text-white/40 mt-1">Acoustic Engineer</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="240">
                <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=200&h=200&fit=crop" class="w-24 h-24 rounded-full object-cover mx-auto border-2 border-white/10 hover:border-gold hover:scale-105 transition-all duration-500" alt="Concierge">
                <h4 class="text-sm text-white/90 font-medium mt-4">Sofia Reyes</h4>
                <p class="text-[0.625rem] uppercase tracking-[0.2em] text-white/40 mt-1">Client Concierge</p>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-[#0a0a0f] border-t" style="border-color: rgba(255,255,255,0.03);">
    <div class="max-w-3xl mx-auto px-6 text-center" data-aos="fade-up">
        <h2 class="font-serif text-3xl md:text-4xl font-light text-white/90">Begin Your <span class="gold">Collection</span></h2>
        <p class="text-white/40 text-sm font-light mt-4 max-w-md mx-auto">Visit our atelier or browse the virtual vault.</p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mt-8">
            <a href="{{ route('user.shop') }}" class="btn-gold px-10 py-3.5">Browse Collection</a>
            <a href="{{ route('user.contact') }}" class="btn-outline-gold">Contact Us</a>
        </div>
    </div>
</section>

@endsection
