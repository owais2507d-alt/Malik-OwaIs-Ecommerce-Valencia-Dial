@extends('layouts.shop')

@section('title', 'Valencia Dial | The Haute Horology Atelier')

@section('content')
    <!-- Hero Section with Background Aura -->
   

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">

     

        <!-- Grid System -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">
            @forelse($watches as $watch)
                <!-- Luxury Watch Card -->
                <div
                    class="group relative flex flex-col justify-between bg-[#0b0b0e] border border-stone-900 shadow-[0_15px_40px_rgba(0,0,0,0.6)] rounded-sm smooth-transition hover:-translate-y-2 hover:border-[#d4af37]/40 hover:shadow-[0_20px_50px_rgba(212,175,55,0.08)] overflow-hidden">

                    <!-- Badge (Top-Left Absolute) -->
                    @if($watch->stock == 0)
                        <div
                            class="absolute top-4 left-4 z-20 bg-red-950/90 text-red-400 border border-red-800/50 text-[9px] uppercase tracking-[0.2em] px-3 py-1 font-medium backdrop-blur-md">
                            Sold Out
                        </div>
                    @elseif($watch->stock <= 3)
                        <div
                            class="absolute top-4 left-4 z-20 bg-amber-950/90 text-amber-400 border border-amber-800/50 text-[9px] uppercase tracking-[0.2em] px-3 py-1 font-medium backdrop-blur-md animate-pulse">
                            Limited Allocation
                        </div>
                    @endif

                    <!-- Image Frame with Interactive Overlay -->
                    <div
                        class="relative w-full h-88 bg-[#07070a] flex items-center justify-center p-6 border-b border-stone-900/50 overflow-hidden group-hover:bg-[#0c0c12] smooth-transition">
                        <!-- Subtle inner glow effect on hover -->
                        <div
                            class="absolute inset-0 bg-gradient from-black/60 to-transparent opacity-0 group-hover:opacity-100 smooth-transition z-10 pointer-events-none">
                        </div>

                        @if($watch->image)
                            <img src="{{ asset('storage/' . $watch->image) }}" alt="{{ $watch->name }}"
                                class="w-full h-full object-contain smooth-transition group-hover:scale-105 duration-700 select-none">
                        @else
                            <div class="flex flex-col items-center space-y-2 text-stone-700">
                                <svg class="w-10 h-10 stroke-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375 0 1 1-.75 0 .375 0 0 1 .75 0Z" />
                                </svg>
                                <span class="text-[9px] uppercase tracking-[0.25em]">No Portrait Available</span>
                            </div>
                        @endif
                    </div>

                    <!-- Watch Info Body -->
                    <div class="p-6 space-y-4 flex-1 flex flex-col justify-between">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <p class="text-[10px] uppercase tracking-[0.25em] text-[#d4af37] font-semibold">
                                    {{ $watch->brand }}</p>
                                <p
                                    class="text-sm font-semibold tracking-wide text-white bg-stone-900/60 px-2.5 py-1 border border-stone-800/40 rounded-sm">
                                    ${{ number_format($watch->price, 2) }}
                                </p>
                            </div>

                            <a href="{{ route('shop.show', $watch->id) }}">
                                <h3
                                    class="text-lg font-medium text-stone-100 tracking-wide group-hover:text-[#d4af37] smooth-transition truncate">
                                    {{ $watch->name }}
                                </h3>
                            </a>

                            <p class="text-stone-500 text-xs font-light leading-relaxed line-clamp-2 pt-1">
                                {{ $watch->description ?? 'No specific craftsmanship chronicles have been documented for this masterpiece.' }}
                            </p>
                        </div>

                        <!-- Action Button Container -->
                      
<div class="pt-4">
    @if($watch->stock > 0)

        <a href="{{ route('shop.show', $watch->id) }}" class="block w-full">
            <button class="relative w-full overflow-hidden text-[10px] uppercase tracking-[0.25em] font-bold py-3.5 px-4 rounded-none smooth-transition cursor-pointer bg-transparent text-[#d4af37] border border-[#d4af37]/30 hover:bg-[#d4af37] hover:text-black hover:border-[#d4af37] shadow-[0_4px_12px_rgba(0,0,0,0.5)]">
                Acquire Masterpiece
            </button>
        </a>
    @else
        <button disabled class="w-full text-[10px] uppercase tracking-[0.25em] font-bold py-3.5 px-4 bg-stone-950 text-stone-700 border border-stone-900 rounded-none cursor-not-allowed">
            Allocation Depleted
        </button>
    @endif
</div>
                    </div>

                </div>
            @empty
                <!-- Empty State Layout -->
                <div
                    class="col-span-full text-center py-24 bg-[#0b0b0e] border border-stone-900 shadow-xl rounded-sm max-w-xl mx-auto w-full space-y-4">
                    <div
                        class="w-12 h-12 rounded-full border border-stone-800 flex items-center justify-center mx-auto text-stone-700">
                        <svg class="w-6 h-6 stroke-[1.2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>
                    </div>
                    <h4 class="luxury-title text-lg uppercase tracking-widest text-stone-300 font-medium">Vault is Empty</h4>
                    <p class="text-stone-500 text-xs max-w-xs mx-auto font-light leading-relaxed">Our horology experts are
                        currently cataloging new masterpieces. Please return shortly.</p>
                </div>
            @endforelse
        </div>

    </div>
@endsection