@extends('layouts.app')

@section('title', 'Contact — Valencia Dial')

@section('content')

<section class="relative min-h-[60vh] flex items-center justify-center overflow-hidden px-4 py-20 md:py-28 bg-[#0a0a0f]">
    <div class="relative z-10 max-w-4xl mx-auto text-center">
        <div data-aos="fade-down" data-aos-delay="200">
            <div class="flex items-center justify-center gap-3">
                <span class="w-6 h-px gold-bg"></span>
                <span class="text-[10px] uppercase tracking-[0.3em] gold font-medium">Connect</span>
            </div>
        </div>
        <h1 class="font-serif text-5xl sm:text-7xl md:text-8xl font-light tracking-[0.08em] text-white/90 leading-[1.1] mt-8" data-aos="fade-up" data-aos-delay="300">
            The <span class="gold">Concierge</span>
        </h1>
        <p class="text-white/40 text-sm sm:text-base max-w-xl mx-auto font-light leading-relaxed mt-6 px-2" data-aos="fade-up" data-aos-delay="400">
            Our private client team awaits. Reach out for inquiries, appointments, or collecting guidance.
        </p>
    </div>
</section>

<div class="w-full max-w-6xl mx-auto px-6 h-px gold-bg opacity-20"></div>

<section class="py-20 bg-[#0a0a0f]">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-16">

            <div class="lg:col-span-2 space-y-10 text-center lg:text-left" data-aos="fade-right">
                @if(session('success'))
                <div class="bg-card-dark border border-green-500/20 text-green-400 px-6 py-4 rounded-xl flex items-center gap-3">
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                @endif

                <div>
                    <div class="flex items-center justify-center lg:justify-start gap-3">
                        <span class="w-6 h-px gold-bg"></span>
                        <span class="text-[10px] uppercase tracking-[0.3em] gold font-medium">Contact</span>
                    </div>
                    <h2 class="font-serif text-3xl font-light text-white/90 mt-5">Speak to Our <span class="gold">Curators</span></h2>
                    <p class="text-white/40 text-sm font-light mt-4 leading-relaxed">
                        Whether you seek a specific reference, wish to arrange a private viewing, or need collecting advice.
                    </p>
                </div>

                <div class="space-y-3">
                    <div class="bg-card-dark rounded-xl p-5 flex items-center gap-4 hover:border-gold/30 transition-all duration-300" style="border: 1px solid rgba(255,255,255,0.04);">
                        <span class="gold text-xs font-medium w-5">@</span>
                        <div>
                            <p class="text-xs uppercase tracking-[0.15em] text-white/60">Email</p>
                            <p class="text-sm text-white/90 font-light">concierge@valenciadial.com</p>
                        </div>
                    </div>
                    <div class="bg-card-dark rounded-xl p-5 flex items-center gap-4 hover:border-gold/30 transition-all duration-300" style="border: 1px solid rgba(255,255,255,0.04);">
                        <span class="gold text-xs font-medium w-5">*</span>
                        <div>
                            <p class="text-xs uppercase tracking-[0.15em] text-white/60">Location</p>
                            <p class="text-sm text-white/90 font-light">Horology District, Geneva</p>
                        </div>
                    </div>
                    <div class="bg-card-dark rounded-xl p-5 flex items-center gap-4 hover:border-gold/30 transition-all duration-300" style="border: 1px solid rgba(255,255,255,0.04);">
                        <span class="gold text-xs font-medium w-5">~</span>
                        <div>
                            <p class="text-xs uppercase tracking-[0.15em] text-white/60">Response Time</p>
                            <p class="text-sm text-white/90 font-light">Within 24 hours</p>
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <p class="text-xs uppercase tracking-[0.15em] text-white/60 mb-4">Follow the Atelier</p>
                    <div class="flex gap-4">
                        <span class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-white/40 gold-hover hover:border-gold transition-all text-[10px] font-medium cursor-default tracking-widest">IG</span>
                        <span class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-white/40 gold-hover hover:border-gold transition-all text-[10px] font-medium cursor-default tracking-widest">TW</span>
                        <span class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-white/40 gold-hover hover:border-gold transition-all text-[10px] font-medium cursor-default tracking-widest">FB</span>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-3" data-aos="fade-left">
                <form action="{{ route('user.contact.send') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs uppercase tracking-[0.15em] text-white/60 mb-2.5">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Your full name"
                                   class="w-full rounded-xl px-5 py-3.5 bg-black/20 border border-white/10 text-white/90 placeholder-white/20 text-sm focus:outline-none focus:border-gold transition-all duration-300 @error('name') border-red-400/40 @enderror">
                            @error('name') <p class="text-red-400/60 text-xs mt-1.5">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-[0.15em] text-white/60 mb-2.5">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="your@email.com"
                                   class="w-full rounded-xl px-5 py-3.5 bg-black/20 border border-white/10 text-white/90 placeholder-white/20 text-sm focus:outline-none focus:border-gold transition-all duration-300 @error('email') border-red-400/40 @enderror">
                            @error('email') <p class="text-red-400/60 text-xs mt-1.5">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="mt-5">
                        <label class="block text-xs uppercase tracking-[0.15em] text-white/60 mb-2.5">Subject</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" placeholder="How can we assist you?"
                               class="w-full rounded-xl px-5 py-3.5 bg-black/20 border border-white/10 text-white/90 placeholder-white/20 text-sm focus:outline-none focus:border-gold transition-all duration-300 @error('subject') border-red-400/40 @enderror">
                        @error('subject') <p class="text-red-400/60 text-xs mt-1.5">{{ $message }}</p> @enderror
                    </div>
                    <div class="mt-5">
                        <label class="block text-xs uppercase tracking-[0.15em] text-white/60 mb-2.5">Message</label>
                        <textarea name="message" rows="5" placeholder="Share your inquiry in detail..."
                                  class="w-full rounded-xl px-5 py-3.5 bg-black/20 border border-white/10 text-white/90 placeholder-white/20 text-sm focus:outline-none focus:border-gold transition-all duration-300 resize-y @error('message') border-red-400/40 @enderror">{{ old('message') }}</textarea>
                        @error('message') <p class="text-red-400/60 text-xs mt-1.5">{{ $message }}</p> @enderror
                    </div>
                    <div class="mt-8">
                        <button type="submit" class="btn-gold px-10 py-3.5">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>

<section class="py-20 bg-[#0a0a0f] border-t" style="border-color: rgba(255,255,255,0.03);">
    <div class="max-w-3xl mx-auto px-6 text-center" data-aos="fade-up">
        <h2 class="font-serif text-3xl md:text-4xl font-light text-white/90">Prefer a <span class="gold">Private Viewing</span>?</h2>
        <p class="text-white/40 text-sm font-light mt-4 max-w-md mx-auto">Schedule an appointment at our Geneva atelier for a personalized curation experience.</p>
        <div class="flex items-center justify-center gap-6 mt-8">
            <span class="text-sm text-white/40 font-light">+41 22 000 00 00</span>
            <span class="w-px h-3 gold-bg opacity-30"></span>
            <span class="text-sm text-white/40 font-light">Mon–Fri, 10:00–19:00</span>
        </div>
    </div>
</section>

@endsection
