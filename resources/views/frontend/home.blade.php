@extends('layouts.shop')

@section('title', 'Valencia Dial - The Haute Horology Atelier')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-12 space-y-16">
    
    <!-- Hero Welcoming Section -->
    <div class="text-center space-y-4 max-w-2xl mx-auto pt-8">
        <span class="text-[9px] uppercase tracking-[0.4em] text-[#d4af37] font-semibold block animate-pulse">Now Boarding Excellence</span>
        <h2 class="luxury-title text-4xl md:text-5xl font-light tracking-wide text-white">The Masterpiece Vault</h2>
        <div class="h-1px w-16 bg-[#d4af37]/40 mx-auto my-4"></div>
        <p class="text-stone-500 text-xs tracking-wide leading-relaxed font-light">
            Explore our meticulously curated selection of fine mechanical engineering and timeless prestige. Every dial tells a legacy.
        </p>
    </div>  

    <!-- Product Grid System -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10">
        @forelse($watches as $watch)
            <div class="group relative flex flex-col justify-between border p-5 smooth-transition bg-[#0b0b0e]/30 hover:bg-[#0b0b0e] hover:shadow-[0_30px_60px_rgba(0,0,0,0.85)]" 
                 style="border-color: var(--border-muted);">
                
                <!-- Watch Image Container with Premium Zoom Effect -->
                <div class="w-full h-80 bg-[#050507] border overflow-hidden p-2 relative flex items-center justify-center" style="border-color: var(--border-muted);">
                    @if($watch->image)
                        <img src="{{ asset('storage/' . $watch->image) }}" alt="{{ $watch->name }}" 
                             class="w-full h-full object-cover smooth-transition group-hover:scale-105 duration-700">
                    @else
                        <div class="flex flex-col items-center space-y-2">
                            <span class="text-[9px] uppercase tracking-[0.3em] text-stone-600">No Portrait Available</span>
                        </div>
                    @endif

                    <!-- Premium Hover Overlay for Specifications Link -->
                    <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 smooth-transition flex items-center justify-center backdrop-blur-[2px]">
                        <a href="#" class="border border-[#d4af37]/40 bg-[#050507] px-4 py-2.5 text-[9px] uppercase tracking-[0.25em] text-stone-200 hover:text-black hover:bg-[#d4af37] smooth-transition font-medium">
                            View Spec Sheet
                     </a>
                    </div>
        

                    <!-- Status Allocation Badges Matrix -->
                    @if($watch->stock == 0)
                        <span class="absolute top-4 right-4 text-[8px] uppercase font-semibold tracking-widest text-red-400 bg-red-950/80 border border-red-900/60 px-2.5 py-1 z-10">
                            Sold Out
                        </span>
                    @elseif($watch->stock <= 3)
                        <span class="absolute top-4 right-4 text-[8px] uppercase font-semibold tracking-widest text-amber-400 bg-amber-950/80 border border-amber-900/60 px-2.5 py-1 animate-pulse z-10">
                            Limited Allocation
                        </span>
                    @endif
                </div>

                <!-- Watch Bio Details -->
                <div class="mt-6 space-y-2.5">
                    <div class="flex justify-between items-baseline">
                        <span class="text-[10px] uppercase tracking-widest text-stone-500 font-semibold">{{ $watch->brand }}</span>
                        <span class="text-xs font-semibold tracking-wide" style="color: var(--text-gold);">
                            ${{ number_format($watch->price, 2) }}
                        </span>
                    </div>
                    
                    <h3 class="text-base font-medium text-white tracking-wide group-hover:text-var(--text-gold) smooth-transition">
                        {{ $watch->name }}
                    </h3>
                    
                    <p class="text-stone-500 text-xs font-light line-clamp-2 h-8 leading-relaxed">
                        {{ $watch->description ?? 'No historical specifications listed for this piece.' }}
                    </p>
                </div>

                <!-- Action Button Matrix -->
                <div class="mt-6 pt-2">
                    @if($watch->stock > 0)
                        <button class="smooth-transition w-full text-[10px] uppercase tracking-[0.2em] font-bold py-3.5 border text-stone-300 hover:text-black hover:bg-[#d4af37] border-[#14141a] hover:border-[#d4af37] bg-[#07070a] cursor-pointer">
                            Acquire Masterpiece
                        </button>
                    @else
                        <button disabled class="w-full text-[10px] uppercase tracking-[0.2em] font-semibold py-3.5 border border-stone-900 text-stone-700 bg-stone-950/40 cursor-not-allowed">
                            Allocation Depleted
                        </button>
                    @endif
                </div>

            </div>
        @empty
            <!-- Beautiful Empty State Placeholder -->
            <div class="col-span-full text-center py-24 border border-dashed flex flex-col items-center justify-center space-y-3" style="border-color: var(--border-muted);">
                <svg class="w-8 h-8 text-stone-700 stroke-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <p class="text-stone-500 text-[10px] uppercase tracking-[0.25em]">The Atelier Vault is currently empty.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection