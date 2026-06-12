@extends('layouts.shop')

@section('title', $watch->name . ' | Valencia Dial Masterpiece')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    
    <!-- Back to Showroom Button -->
    <div class="mb-12">
        <a href="{{ route('shop.index') }}" class="inline-flex items-center space-x-2 text-stone-500 hover:text-[#d4af37] text-xs uppercase tracking-widest smooth-transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            <span>Return to Atelier</span>
        </a>
    </div>

    <!-- Main Dynamic Showcase Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        
        <!-- Left Column: Portrait Frame -->
        <div class="bg-[#0b0b0e] border border-stone-900 rounded-sm p-8 flex items-center justify-center h-500px shadow-2xl relative group overflow-hidden">
            <div class="absolute inset-0 bg-gradient from-transparent to-black/40 pointer-events-none"></div>
            @if($watch->image)
                <img src="{{ asset('storage/' . $watch->image) }}" alt="{{ $watch->name }}" class="max-h-full max-w-full object-contain smooth-transition group-hover:scale-102 duration-500">
            @else
                <span class="text-[10px] uppercase tracking-[0.3em] text-stone-700">No Portrait Registered</span>
            @endif
        </div>

        <!-- Right Column: Watch Chronology & Actions -->
        <div class="space-y-8">
            <div class="space-y-3">
                <span class="text-[10px] uppercase tracking-[0.4em] text-[#d4af37] font-bold block">{{ $watch->brand }}</span>
                <h1 class="luxury-title text-3xl md:text-4xl text-white font-light tracking-wide uppercase">{{ $watch->name }}</h1>
                <div class="h-1px w-20 bg-[#d4af37]/30 my-4"></div>
                <p class="text-xl font-semibold tracking-wider text-white">${{ number_format($watch->price, 2) }}</p>
            </div>

            <!-- Specifications / Description -->
            <div class="space-y-4 bg-[#0b0b0e]/40 p-6 border border-stone-900/60 rounded-sm">
                <h3 class="text-[10px] uppercase tracking-widest text-stone-400 font-semibold">The Craftsmanship Story</h3>
                <p class="text-stone-400 text-xs font-light leading-relaxed tracking-wide">
                    {{ $watch->description ?? 'No historical specifications listed for this piece. It remains an enigmatic marvel of timekeeping engineering.' }}
                </p>
            </div>

            <!-- Allocation & Stock Meta Data -->
            <div class="flex items-center space-x-6 text-[11px] uppercase tracking-widest border-y border-stone-900/60 py-4">
                <span class="text-stone-500">Allocation Status:</span>
                @if($watch->stock > 3)
                    <span class="text-emerald-400 font-medium">Available in Vault ({{ $watch->stock }} Left)</span>
                @elseif($watch->stock > 0)
                    <span class="text-amber-400 font-medium animate-pulse">Critical Allocation ({{ $watch->stock }} Left)</span>
                @else
                    <span class="text-red-400 font-medium">Depleted / Sold Out</span>
                @endif
            </div>

            <!-- Purchase Trigger -->
            <div>
                @if($watch->stock > 0)
                    <button class="w-full lg:w-auto min-w-240px text-[10px] uppercase tracking-[0.25em] font-bold py-4 px-8 bg-[#d4af37] text-black border border-[#d4af37] smooth-transition hover:bg-transparent hover:text-[#d4af37] cursor-pointer shadow-lg">
                        Acquire Masterpiece
                    </button>
                @else
                    <button disabled class="w-full lg:w-auto min-w-240px text-[10px] uppercase tracking-[0.25em] font-bold py-4 px-8 bg-stone-950 text-stone-700 border border-stone-900 cursor-not-allowed">
                        Vault Closed
                    </button>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection