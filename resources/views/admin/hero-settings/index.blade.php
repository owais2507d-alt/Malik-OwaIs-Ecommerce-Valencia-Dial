@extends('layouts.admin')

@section('title', 'Hero Settings — Admin')

@section('content')
<div class="p-6 bg-[#050507] min-h-screen text-stone-200">
    <div class="mb-8 pb-5 border-b border-stone-900">
        <h1 class="text-xl md:text-2xl font-light tracking-widest uppercase text-white">Hero Section Settings</h1>
        <p class="text-xs text-stone-500 tracking-wider mt-1">Customize the home page hero banner content.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs tracking-wide">
            {{ session('success') }}
        </div>
    @endif

    <div class="max-w-3xl bg-[#0a0a0d]/60 border border-stone-900/80 backdrop-blur-md p-8">
        <form action="{{ route('admin.hero-settings.update') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.2em] text-stone-400 font-medium mb-2">Hero Title (Left Part)</label>
                    <input type="text" name="hero_title" value="{{ old('hero_title', \App\Models\Setting::getValue('hero_title', 'Valencia')) }}"
                           class="w-full bg-[#050507] border border-stone-900 px-4 py-3 text-sm text-white placeholder-stone-700 focus:outline-none focus:border-[#e5c158]/40 transition-colors">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.2em] text-stone-400 font-medium mb-2">Hero Title Accent (Gold Part)</label>
                    <input type="text" name="hero_title_accent" value="{{ old('hero_title_accent', \App\Models\Setting::getValue('hero_title_accent', 'Dial')) }}"
                           class="w-full bg-[#050507] border border-stone-900 px-4 py-3 text-sm text-white placeholder-stone-700 focus:outline-none focus:border-[#e5c158]/40 transition-colors">
                </div>
            </div>

            <div>
                <label class="block text-[10px] uppercase tracking-[0.2em] text-stone-400 font-medium mb-2">Tagline (e.g. "Est. 2026")</label>
                <input type="text" name="hero_tagline" value="{{ old('hero_tagline', \App\Models\Setting::getValue('hero_tagline', 'Est. 2026')) }}"
                       class="w-full bg-[#050507] border border-stone-900 px-4 py-3 text-sm text-white placeholder-stone-700 focus:outline-none focus:border-[#e5c158]/40 transition-colors">
            </div>

            <div>
                <label class="block text-[10px] uppercase tracking-[0.2em] text-stone-400 font-medium mb-2">Subtitle</label>
                <textarea name="hero_subtitle" rows="3"
                          class="w-full bg-[#050507] border border-stone-900 px-4 py-3 text-sm text-white placeholder-stone-700 focus:outline-none focus:border-[#e5c158]/40 transition-colors">{{ old('hero_subtitle', \App\Models\Setting::getValue('hero_subtitle', 'A digital atelier where exceptional craftsmanship meets timeless design.')) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.2em] text-stone-400 font-medium mb-2">Primary CTA Text</label>
                    <input type="text" name="hero_cta_primary_text" value="{{ old('hero_cta_primary_text', \App\Models\Setting::getValue('hero_cta_primary_text', 'Explore Collection')) }}"
                           class="w-full bg-[#050507] border border-stone-900 px-4 py-3 text-sm text-white placeholder-stone-700 focus:outline-none focus:border-[#e5c158]/40 transition-colors">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.2em] text-stone-400 font-medium mb-2">Primary CTA Link</label>
                    <input type="text" name="hero_cta_primary_link" value="{{ old('hero_cta_primary_link', \App\Models\Setting::getValue('hero_cta_primary_link', route('user.shop'))) }}"
                           class="w-full bg-[#050507] border border-stone-900 px-4 py-3 text-sm text-white placeholder-stone-700 focus:outline-none focus:border-[#e5c158]/40 transition-colors">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.2em] text-stone-400 font-medium mb-2">Secondary CTA Text</label>
                    <input type="text" name="hero_cta_secondary_text" value="{{ old('hero_cta_secondary_text', \App\Models\Setting::getValue('hero_cta_secondary_text', 'Join the Vault')) }}"
                           class="w-full bg-[#050507] border border-stone-900 px-4 py-3 text-sm text-white placeholder-stone-700 focus:outline-none focus:border-[#e5c158]/40 transition-colors">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.2em] text-stone-400 font-medium mb-2">Secondary CTA Link</label>
                    <input type="text" name="hero_cta_secondary_link" value="{{ old('hero_cta_secondary_link', \App\Models\Setting::getValue('hero_cta_secondary_link', route('user.register'))) }}"
                           class="w-full bg-[#050507] border border-stone-900 px-4 py-3 text-sm text-white placeholder-stone-700 focus:outline-none focus:border-[#e5c158]/40 transition-colors">
                </div>
            </div>

            <div>
                <label class="block text-[10px] uppercase tracking-[0.2em] text-stone-400 font-medium mb-2">Background Video URL</label>
                <input type="text" name="hero_video" value="{{ old('hero_video', \App\Models\Setting::getValue('hero_video', 'https://cdn.coverr.co/videos/coverr-luxury-watch-on-a-marble-surface-5767/1080p.mp4')) }}"
                       class="w-full bg-[#050507] border border-stone-900 px-4 py-3 text-sm text-white placeholder-stone-700 focus:outline-none focus:border-[#e5c158]/40 transition-colors">
                <p class="text-[10px] text-stone-600 mt-1 tracking-wide">MP4 video URL. Will be used as background in the hero section.</p>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full py-3 bg-[#e5c158] hover:bg-[#d4b047] text-black font-semibold text-xs tracking-[0.25em] uppercase transition-all duration-300">
                    Update Hero Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
