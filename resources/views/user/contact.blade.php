@extends('layouts.app')

@section('title', 'Contact — Valencia Dial')

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
    .form-input { width: 100%; padding: 0.85rem 1.25rem; background: #0a0a0e; border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; color: #f5f5f7; font-size: 0.9rem; outline: none; transition: all 0.3s ease; }
    .form-input:focus { border-color: rgba(212, 175, 55, 0.3); background: #111; }
    .form-input::placeholder { color: #555; }
    .form-input.error { border-color: rgba(239, 68, 68, 0.4); }
    .info-card { padding: 1.5rem; background: rgba(10,10,14,0.4); border: 1px solid rgba(255,255,255,0.05); border-radius: 12px; transition: all 0.3s ease; }
    .info-card:hover { border-color: rgba(212, 175, 55, 0.15); background: rgba(10,10,14,0.7); }
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
            <span class="text-[10px] sm:text-xs uppercase tracking-[0.5em] text-dark-gold font-medium">Get in Touch</span>
            <span class="h-px w-10 sm:w-16 bg-gradient-to-l from-transparent to-[#e5c158] opacity-60"></span>
        </div>

        <h1 class="luxury-title text-5xl sm:text-7xl md:text-8xl font-light tracking-[0.12em] text-stone-200 uppercase leading-[1.1]" data-aos="zoom-in" data-aos-delay="300">
            The <br class="sm:hidden">
            <span class="font-normal text-dark-gold">Concierge</span>
        </h1>

        <p class="text-stone-500 text-sm sm:text-base max-w-2xl mx-auto font-light leading-relaxed tracking-widest px-2" data-aos="fade-up" data-aos-delay="400">
            Our private client team awaits. Reach out for inquiries, appointments, or collecting guidance.
        </p>

        <!-- scroll indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1 opacity-40" data-aos="fade-up" data-aos-delay="600">
            <span class="text-[8px] uppercase tracking-[0.3em] text-stone-500">Scroll</span>
            <div class="w-px h-10 bg-gradient-to-b from-dark-gold to-transparent"></div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-24 bg-[#040405] border-t border-[rgba(255,255,255,0.04)]">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-12">

            <!-- Info -->
            <div class="lg:col-span-2 space-y-8" data-aos="fade-right">
                @if(session('success'))
                <div class="bg-[rgba(212,175,55,0.08)] border border-[rgba(212,175,55,0.15)] text-[#d4af37] px-6 py-4 rounded-xl flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                @endif

                <div>
                    <span class="section-label">Contact</span>
                    <h2 class="font-display text-3xl font-light text-white mt-4">Speak to Our <span class="text-[#d4af37]">Curators</span></h2>
                    <p class="text-[#a1a1aa] text-sm font-light mt-4 leading-relaxed">
                        Whether you seek a specific reference, wish to arrange a private viewing, or need collecting advice — our team is at your service.
                    </p>
                </div>

                <div class="space-y-4">
                    <div class="info-card flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-[rgba(212,175,55,0.08)] border border-[rgba(212,175,55,0.1)] flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-[#d4af37]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-[0.15em] text-[#666]">Email</p>
                            <p class="text-sm text-white">concierge@valenciadial.com</p>
                        </div>
                    </div>
                    <div class="info-card flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-[rgba(212,175,55,0.08)] border border-[rgba(212,175,55,0.1)] flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-[#d4af37]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-[0.15em] text-[#666]">Location</p>
                            <p class="text-sm text-white">Horology District, Geneva</p>
                        </div>
                    </div>
                    <div class="info-card flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-[rgba(212,175,55,0.08)] border border-[rgba(212,175,55,0.1)] flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-[#d4af37]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-[0.15em] text-[#666]">Response Time</p>
                            <p class="text-sm text-white">Within 24 hours</p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-[rgba(255,255,255,0.06)] pt-6">
                    <p class="text-xs uppercase tracking-[0.15em] text-[#666] mb-3">Follow the Atelier</p>
                    <div class="flex gap-4">
                        <span class="w-10 h-10 rounded-full border border-[rgba(255,255,255,0.08)] flex items-center justify-center text-[#a1a1aa] hover:text-[#d4af37] hover:border-[#d4af37]/30 transition-all text-xs font-medium cursor-default">IG</span>
                        <span class="w-10 h-10 rounded-full border border-[rgba(255,255,255,0.08)] flex items-center justify-center text-[#a1a1aa] hover:text-[#d4af37] hover:border-[#d4af37]/30 transition-all text-xs font-medium cursor-default">TW</span>
                        <span class="w-10 h-10 rounded-full border border-[rgba(255,255,255,0.08)] flex items-center justify-center text-[#a1a1aa] hover:text-[#d4af37] hover:border-[#d4af37]/30 transition-all text-xs font-medium cursor-default">FB</span>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="lg:col-span-3" data-aos="fade-left">
                <div class="bg-[rgba(10,10,14,0.3)] border border-[rgba(255,255,255,0.05)] rounded-2xl p-8 md:p-10">
                    <form action="{{ route('user.contact.send') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs uppercase tracking-[0.15em] text-[#a1a1aa] mb-2">Name <span class="text-red-400/60">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Your full name" class="form-input @error('name') error @enderror">
                                @error('name') <p class="text-red-400/60 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-[0.15em] text-[#a1a1aa] mb-2">Email <span class="text-red-400/60">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="your@email.com" class="form-input @error('email') error @enderror">
                                @error('email') <p class="text-red-400/60 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="mt-5">
                            <label class="block text-xs uppercase tracking-[0.15em] text-[#a1a1aa] mb-2">Subject <span class="text-red-400/60">*</span></label>
                            <input type="text" name="subject" value="{{ old('subject') }}" placeholder="How can we assist you?" class="form-input @error('subject') error @enderror">
                            @error('subject') <p class="text-red-400/60 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="mt-5">
                            <label class="block text-xs uppercase tracking-[0.15em] text-[#a1a1aa] mb-2">Message <span class="text-red-400/60">*</span></label>
                            <textarea name="message" rows="6" placeholder="Share your inquiry in detail..." class="form-input resize-y @error('message') error @enderror">{{ old('message') }}</textarea>
                            @error('message') <p class="text-red-400/60 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="mt-8">
                            <button type="submit" class="w-full bg-[#d4af37] hover:bg-white text-black font-medium px-8 py-4 rounded-xl text-[0.625rem] uppercase tracking-[0.15em] transition-all">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Map / CTA -->
<section class="py-20 bg-[#060608] border-t border-[rgba(255,255,255,0.04)]">
    <div class="max-w-3xl mx-auto px-6 text-center" data-aos="fade-up">
        <h2 class="font-display text-3xl md:text-4xl font-light text-white">Prefer a <span class="text-[#d4af37]">Private Viewing</span>?</h2>
        <p class="text-[#a1a1aa] text-sm font-light mt-4 max-w-md mx-auto">Schedule an appointment at our Geneva atelier for a personalized curation experience.</p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mt-8">
            <span class="text-sm text-[#a1a1aa]">+41 22 000 00 00</span>
            <span class="w-px h-4 bg-[rgba(255,255,255,0.06)] hidden sm:block"></span>
            <span class="text-sm text-[#a1a1aa]">Mon–Fri, 10:00–19:00</span>
        </div>
    </div>
</section>

@endsection
