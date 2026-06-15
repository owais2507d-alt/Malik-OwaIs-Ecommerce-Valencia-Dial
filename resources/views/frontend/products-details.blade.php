@extends('layouts.shop')

@section('title', $watch->name . ' | Valencia Dial Atelier')

@section('content')
<div class="min-h-screen bg-[#040405] text-stone-300 py-16 lg:py-28 px-4 sm:px-6 lg:px-16">
    <div class="max-w-1400px mx-auto">
        
        <!-- Back Navigation Pipeline -->
        <div class="mb-12 sm:mb-16">
            <a href="{{ route('shop.index') }}" class="text-[10px] uppercase tracking-[0.35em] text-stone-500 hover:text-stone-100 smooth-transition flex items-center space-x-2">
                <span class="hover-gold-glow">← Return to Atelier Vault</span>
            </a>
        </div>

        <!-- Master Content Split Frame -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-24 items-center">
            
            <!-- Left Column: Premium Artwork Frame -->
            <div class="lg:col-span-6 bg-[#07070a]/60 border border-stone-900/80 p-6 sm:p-12 flex items-center justify-center relative group overflow-hidden shadow-2xl shadow-black">
                <!-- Premium Gold Ambient Shadow Profile -->
                <div class="absolute w-250px h-250px opacity-[0.12] blur-[100px] rounded-full pointer-events-none transition-all duration-700 group-hover:opacity-20" style="background-color: var(--color-dark-gold);"></div>
                
                @if($watch->image)
                    <img src="{{ asset('storage/' . $watch->image) }}" alt="{{ $watch->name }}" class="w-full max-h-500px sm:max-h-580px object-contain smooth-transition group-hover:scale-105 duration-700 filter drop-shadow-[0_10px_30px_rgba(0,0,0,0.8)]">
                @else
                    <div class="w-full h-380px sm:h-480px bg-[#020203] flex flex-col justify-center items-center text-stone-700 tracking-[0.4em] text-[9px] uppercase space-y-3">
                        <span class="border border-stone-900 px-4 py-2">No Artwork Rendered</span>
                    </div>
                @endif
            </div>

            <!-- Right Column: Exquisite Details Pipeline -->
            <div class="lg:col-span-6 space-y-10 sm:space-y-12">
                
                <!-- Main Header Frame -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-2">
                        <span class="w-1.5 h-1.5 rounded-full" style="background-color: var(--color-dark-gold);"></span>
                        <p class="text-[10px] sm:text-[11px] uppercase tracking-[0.55em] text-dark-gold font-semibold">
                            {{ $watch->brand ?? 'Haute Horology' }}
                        </p>
                    </div>
                    
                    <h1 class="luxury-title text-3xl sm:text-5xl md:text-6xl font-light tracking-[0.12em] text-stone-100 uppercase leading-tight">
                        {{ $watch->name }}
                    </h1>
                    
                    <div class="pt-2 flex items-baseline space-x-2">
                        <span class="text-2xl sm:text-3xl font-light tracking-0.1em text-stone-200">
                            ${{ number_format($watch->price, 2) }}
                        </span>
                        <span class="text-[10px] text-stone-600 tracking-[0.2em] uppercase font-medium">USD</span>
                    </div>
                </div>

                <hr class="border-stone-900/60">

                <!-- Provenance Summary -->
                <div class="space-y-4">
                    <h4 class="text-[10px] uppercase tracking-[0.35em] text-stone-400 font-medium">Provenance & Narrative</h4>
                    <p class="text-stone-500 text-xs sm:text-sm font-light leading-2 tracking-widest">
                        {{ $watch->description ?? 'This mechanical masterpiece represents the pinnacle of micro-engineering. Preserved in pristine condition, its architecture showcases the absolute dedication of master watchmakers.' }}
                    </p>
                </div>

                <!-- Technical Specs Frame -->
                <div class="space-y-4 pt-2">
                    <h4 class="text-[10px] uppercase tracking-[0.35em] text-stone-400 font-medium">Technical Blueprint</h4>
                    
                    <div class="border border-stone-900/60 bg-[#060608]/40 text-[11px] tracking-widest font-light backdrop-blur-md">
                        <div class="flex justify-between items-center border-b border-stone-900/40 p-4 px-5">
                            <span class="text-stone-600 uppercase text-[9px] tracking-[0.25em]">Reference</span>
                            <span class="text-stone-300 font-medium tracking-widest">{{ $watch->reference_number ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-stone-900/40 p-4 px-5">
                            <span class="text-stone-600 uppercase text-[9px] tracking-[0.25em]">Movement Type</span>
                            <span class="text-stone-400 font-light">{{ $watch->movement ?? 'Automatic Caliber' }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-stone-900/40 p-4 px-5">
                            <span class="text-stone-600 uppercase text-[9px] tracking-[0.25em]">Case Diameter</span>
                            <span class="text-stone-400 font-light">{{ $watch->case_size ?? '40mm' }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-stone-900/40 p-4 px-5">
                            <span class="text-stone-600 uppercase text-[9px] tracking-[0.25em]">Material Base</span>
                            <span class="text-stone-400 font-light">{{ $watch->material ?? 'Oystersteel / Gold' }}</span>
                        </div>
                        <div class="flex justify-between items-center p-4 px-5 bg-stone-950/30">
                            <span class="text-stone-600 uppercase text-[9px] tracking-[0.25em]">Condition State</span>
                            <span class="text-dark-gold uppercase text-[10px] font-semibold tracking-[0.2em]">{{ $watch->condition ?? 'Unworn / Investment Grade' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Action Module Component -->
                <div class="pt-4 space-y-5">
                    <!-- Dynamic Cart Action Form -->
                    <form action="{{ route('cart.add') }}" method="POST" class="w-full">
                        @csrf
                        <input type="hidden" name="watch_id" value="{{ $watch->id }}">
                        
                        <div class="flex flex-col sm:flex-row items-center gap-4">
                            <button type="submit" class="w-full text-[10px] uppercase tracking-[0.35em] font-semibold py-4 px-8 text-black smooth-transition hover:opacity-90 hover:scale-[1.01] text-center cursor-pointer shadow-xl shadow-black/80" style="background-color: var(--color-dark-gold);">
                                Request Allocation (Add to Cart)
                            </button>
                        </div>
                    </form>
                    
                    <div class="flex items-center justify-center sm:justify-start space-x-3 text-[9px] text-stone-600 tracking-[0.25em] uppercase leading-relaxed pt-2">
                        <span>🔒</span>
                        <span>fully insured armored courier transit dispatched worldwide.</span>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection