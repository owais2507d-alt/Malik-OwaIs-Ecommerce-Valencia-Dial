@extends('layouts.app')

@section('title', 'Contact — Valencia Dial')

@push('styles')
<style>
:root { --gold: #d4af37;--gold-light: #e5c158;--bg-dark: #040405; }
body { background: var(--bg-dark);color: #f5f5f7;font-family: 'Montserrat',sans-serif;-webkit-font-smoothing: antialiased; }
.section-label { display: inline-flex;align-items: center;gap: .75rem;font-size: .625rem;letter-spacing: .3em;text-transform: uppercase;color: var(--gold);font-weight: 400; }
.section-label::before { content: '';width: 1.5rem;height: 1px;background: rgba(212,175,55,.35); }
.info-card { padding: 1.25rem 1.5rem;background: rgba(10,10,14,.4);border: 1px solid rgba(255,255,255,.04);border-radius: 8px;transition: all .3s ease; }
.info-card:hover { border-color: rgba(212,175,55,.12);background: rgba(10,10,14,.6); }
.form-input { width: 100%;padding: .85rem 1.25rem;background: #0a0a0e;border: 1px solid rgba(255,255,255,.06);border-radius: 8px;color: #f5f5f7;font-size: .85rem;outline: none;transition: all .3s ease;font-family: 'Montserrat',sans-serif; }
.form-input:focus { border-color: rgba(212,175,55,.25);background: #111; }
.form-input::placeholder { color: rgba(255,255,255,.15); }
.form-input.error { border-color: rgba(239,68,68,.4); }
.gold-line { width: 100%;height: 1px;background: rgba(212,175,55,.15);margin: 2rem 0; }
::-webkit-scrollbar { width: 4px;background: #0a0a0d; }
::-webkit-scrollbar-thumb { background: var(--gold);border-radius: 20px; }
[data-aos] { pointer-events: none; }
[data-aos].aos-animate { pointer-events: auto; }
</style>
@endpush

@section('content')

<section class="relative min-h-[60vh] flex items-center justify-center overflow-hidden px-4 py-20 md:py-28">
    <div class="relative z-10 max-w-4xl mx-auto text-center">
        <div data-aos="fade-down" data-aos-delay="200">
            <span class="section-label justify-center">Connect</span>
        </div>
        <h1 class="luxury-title text-5xl sm:text-7xl md:text-8xl font-light tracking-[0.08em] text-white leading-[1.1] mt-8" data-aos="fade-up" data-aos-delay="300">
            The <span class="text-[#d4af37]">Concierge</span>
        </h1>
        <p class="text-stone-500 text-sm sm:text-base max-w-xl mx-auto font-light leading-relaxed mt-6 px-2" data-aos="fade-up" data-aos-delay="400">
            Our private client team awaits. Reach out for inquiries, appointments, or collecting guidance.
        </p>
    </div>
</section>

<div class="gold-line max-w-6xl mx-auto px-6"></div>

<section class="py-20 bg-[#040405]">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-16">

            <div class="lg:col-span-2 space-y-10" data-aos="fade-right">
                @if(session('success'))
                <div class="bg-[rgba(212,175,55,0.06)] border border-[rgba(212,175,55,0.12)] text-[#d4af37] px-6 py-4 rounded-lg flex items-center gap-3">
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                @endif

                <div>
                    <span class="section-label">Contact</span>
                    <h2 class="luxury-title text-3xl font-light text-white mt-5">Speak to Our <span class="text-[#d4af37]">Curators</span></h2>
                    <p class="text-stone-500 text-sm font-light mt-4 leading-relaxed">
                        Whether you seek a specific reference, wish to arrange a private viewing, or need collecting advice.
                    </p>
                </div>

                <div class="space-y-3">
                    <div class="info-card flex items-center gap-4">
                        <span class="text-[#d4af37] text-xs font-medium w-5">@</span>
                        <div>
                            <p class="text-xs uppercase tracking-[0.15em] text-stone-500">Email</p>
                            <p class="text-sm text-white font-light">concierge@valenciadial.com</p>
                        </div>
                    </div>
                    <div class="info-card flex items-center gap-4">
                        <span class="text-[#d4af37] text-xs font-medium w-5">*</span>
                        <div>
                            <p class="text-xs uppercase tracking-[0.15em] text-stone-500">Location</p>
                            <p class="text-sm text-white font-light">Horology District, Geneva</p>
                        </div>
                    </div>
                    <div class="info-card flex items-center gap-4">
                        <span class="text-[#d4af37] text-xs font-medium w-5">~</span>
                        <div>
                            <p class="text-xs uppercase tracking-[0.15em] text-stone-500">Response Time</p>
                            <p class="text-sm text-white font-light">Within 24 hours</p>
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <p class="text-xs uppercase tracking-[0.15em] text-stone-500 mb-4">Follow the Atelier</p>
                    <div class="flex gap-4">
                        <span class="w-10 h-10 rounded-full border border-[rgba(255,255,255,0.06)] flex items-center justify-center text-stone-500 hover:text-[#d4af37] hover:border-[rgba(212,175,55,0.2)] transition-all text-[10px] font-medium cursor-default tracking-widest">IG</span>
                        <span class="w-10 h-10 rounded-full border border-[rgba(255,255,255,0.06)] flex items-center justify-center text-stone-500 hover:text-[#d4af37] hover:border-[rgba(212,175,55,0.2)] transition-all text-[10px] font-medium cursor-default tracking-widest">TW</span>
                        <span class="w-10 h-10 rounded-full border border-[rgba(255,255,255,0.06)] flex items-center justify-center text-stone-500 hover:text-[#d4af37] hover:border-[rgba(212,175,55,0.2)] transition-all text-[10px] font-medium cursor-default tracking-widest">FB</span>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-3" data-aos="fade-left">
                <form action="{{ route('user.contact.send') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs uppercase tracking-[0.15em] text-stone-500 mb-2.5">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Your full name" class="form-input @error('name') error @enderror">
                            @error('name') <p class="text-red-400/60 text-xs mt-1.5">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-[0.15em] text-stone-500 mb-2.5">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="your@email.com" class="form-input @error('email') error @enderror">
                            @error('email') <p class="text-red-400/60 text-xs mt-1.5">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="mt-5">
                        <label class="block text-xs uppercase tracking-[0.15em] text-stone-500 mb-2.5">Subject</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" placeholder="How can we assist you?" class="form-input @error('subject') error @enderror">
                        @error('subject') <p class="text-red-400/60 text-xs mt-1.5">{{ $message }}</p> @enderror
                    </div>
                    <div class="mt-5">
                        <label class="block text-xs uppercase tracking-[0.15em] text-stone-500 mb-2.5">Message</label>
                        <textarea name="message" rows="5" placeholder="Share your inquiry in detail..." class="form-input resize-y @error('message') error @enderror">{{ old('message') }}</textarea>
                        @error('message') <p class="text-red-400/60 text-xs mt-1.5">{{ $message }}</p> @enderror
                    </div>
                    <div class="mt-8">
                        <button type="submit" class="btn-primary">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>

<section class="py-20 bg-[#060608] border-t border-[rgba(255,255,255,0.03)]">
    <div class="max-w-3xl mx-auto px-6 text-center" data-aos="fade-up">
        <h2 class="luxury-title text-3xl md:text-4xl font-light text-white">Prefer a <span class="text-[#d4af37]">Private Viewing</span>?</h2>
        <p class="text-stone-500 text-sm font-light mt-4 max-w-md mx-auto">Schedule an appointment at our Geneva atelier for a personalized curation experience.</p>
        <div class="flex items-center justify-center gap-6 mt-8">
            <span class="text-sm text-stone-400 font-light">+41 22 000 00 00</span>
            <span class="w-px h-3 bg-[rgba(255,255,255,0.06)]"></span>
            <span class="text-sm text-stone-400 font-light">Mon–Fri, 10:00–19:00</span>
        </div>
    </div>
</section>

@endsection
