# Valencia Dial - Premium Home Page UI Enhancement Prompt

Act as an expert frontend engineer specializing in luxury e-commerce interfaces (similar to Apple, Bang & Olufsen, and premium watch brands). Your goal is to completely rewrite or generate the frontend home page template using **Tailwind CSS**, strictly matching the visual language of the provided design strategy.

## Global Design Rules:
- **Color Palette:** Primary Dark (`#050507`), Secondary Card Dark (`#0a0a0d`), Minimal Luxury Gold (`#e5c158`), Clean Accents (Burgundy/Muted Purple for badges).
- **Typography:** Wide tracking (`tracking-widest`), uppercase labels for navigation/headers, clean and crisp font weights.
- **Layout:** Smooth transitions, generous whitespace, sharp lines, and interactive micro-interactions.

---

## Complete HTML/Blade Component Blueprint

```html
<!-- Main Home Page Container -->
<div class="bg-[#050507] min-h-screen text-stone-200 font-sans antialiased">

    <!-- 1. HERO SECTION -->
    <section class="relative min-h-[85vh] flex items-center justify-center border-b border-stone-900 bg-gradient-to-b from-[#0a0a0d] to-[#050507] px-6">
        <div class="max-w-7xl w-full grid grid-cols-1 lg:grid-cols-2 gap-12 items-center py-12">
            <!-- Text Content -->
            <div class="space-y-6 text-center lg:text-left">
                <span class="text-[11px] uppercase tracking-[0.3em] text-[#e5c158] font-semibold">The Horizon Collection</span>
                <h1 class="text-4xl md:text-6xl font-extralight tracking-widest text-white leading-tight uppercase">
                    Timeless <br class="hidden md:block"><span class="font-normal text-[#e5c158]">Engineering</span>
                </h1>
                <p class="text-xs md:text-sm text-stone-400 tracking-wider max-w-md mx-auto lg:mx-0 font-light leading-relaxed">
                    Experience luxury audio tech and micro-engineered luxury timepieces forged for modern pioneers.
                </p>
                <div class="pt-4 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="#" class="px-8 py-3 bg-[#e5c158] hover:bg-[#d4b047] text-black text-xs font-semibold tracking-[0.2em] uppercase transition-all duration-300">
                        Explore Collection
                    </a>
                    <a href="#" class="px-8 py-3 border border-stone-800 hover:border-[#e5c158]/50 text-white text-xs font-medium tracking-[0.2em] uppercase transition-all duration-300 bg-stone-950/40">
                        Watch Film
                    </a>
                </div>
            </div>
            <!-- Visual Showcase Space -->
            <div class="relative flex justify-center items-center">
                <div class="absolute w-72 h-72 md:w-96 md:h-96 bg-[#e5c158]/5 rounded-full blur-3xl"></div>
                <!-- Placeholder for dynamic hero asset image -->
                <div class="relative w-full max-w-md h-[400px] bg-[#0a0a0d]/50 border border-stone-900 flex items-center justify-center backdrop-blur-md">
                    <span class="text-[10px] tracking-[0.3em] text-stone-600 uppercase">[Premium Product Close-Up Rendering]</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. QUICK CATEGORY CIRCULAR CAROUSEL -->
    <section class="py-16 border-b border-stone-900 bg-[#07070a]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16">
                <!-- Category Element Sample (Loop this via backend items) -->
                <a href="#" class="group flex flex-col items-center space-y-4">
                    <div class="w-20 h-20 md:w-24 md:h-24 rounded-full border border-stone-800 bg-[#0a0a0d] p-1 flex items-center justify-center transition-all duration-300 group-hover:border-[#e5c158] group-hover:scale-105 shadow-xl">
                        <div class="w-full h-full rounded-full bg-[#050507] overflow-hidden flex items-center justify-center">
                            <span class="text-[9px] text-stone-600 tracking-wider uppercase">IMG</span>
                        </div>
                    </div>
                    <span class="text-[10px] uppercase tracking-[0.2em] text-stone-400 transition-colors duration-300 group-hover:text-[#e5c158] font-medium">Watches</span>
                </a>
                
                <a href="#" class="group flex flex-col items-center space-y-4">
                    <div class="w-20 h-20 md:w-24 md:h-24 rounded-full border border-stone-800 bg-[#0a0a0d] p-1 flex items-center justify-center transition-all duration-300 group-hover:border-[#e5c158] group-hover:scale-105 shadow-xl">
                        <div class="w-full h-full rounded-full bg-[#050507] overflow-hidden flex items-center justify-center">
                            <span class="text-[9px] text-stone-600 tracking-wider uppercase">IMG</span>
                        </div>
                    </div>
                    <span class="text-[10px] uppercase tracking-[0.2em] text-stone-400 transition-colors duration-300 group-hover:text-[#e5c158] font-medium">Earbuds</span>
                </a>

                <a href="#" class="group flex flex-col items-center space-y-4">
                    <div class="w-20 h-20 md:w-24 md:h-24 rounded-full border border-stone-800 bg-[#0a0a0d] p-1 flex items-center justify-center transition-all duration-300 group-hover:border-[#e5c158] group-hover:scale-105 shadow-xl">
                        <div class="w-full h-full rounded-full bg-[#050507] overflow-hidden flex items-center justify-center">
                            <span class="text-[9px] text-stone-600 tracking-wider uppercase">IMG</span>
                        </div>
                    </div>
                    <span class="text-[10px] uppercase tracking-[0.2em] text-stone-400 transition-colors duration-300 group-hover:text-[#e5c158] font-medium">Accessories</span>
                </a>
            </div>
        </div>
    </section>

    <!-- 3. BEST SELLERS / PRODUCT GRID SECTION WITH SEAMLESS CROSS-FADE HOVER -->
    <section class="py-20 px-6 max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-12 pb-4 border-b border-stone-900">
            <div>
                <h2 class="text-xl md:text-2xl font-light tracking-widest uppercase text-white">Best Sellers</h2>
                <p class="text-[11px] text-stone-500 tracking-wider mt-1">Curated masterpieces engineered to perfection.</p>
            </div>
            <a href="#" class="text-[11px] uppercase tracking-[0.2em] text-[#e5c158] hover:text-white transition-colors duration-300">View All Matrix →</a>
        </div>

        <!-- 4x4 Grid System -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            
            <!-- CORE PRODUCT CARD START (Populate dynamically via Blade template backend variables) -->
            <div class="group relative w-full bg-[#0a0a0d]/40 border border-stone-900/80 p-5 flex flex-col transition-all duration-500 hover:border-stone-800 hover:bg-[#0a0a0d] hover:-translate-y-1">
                
                <!-- Badge and Interactive Image Space -->
                <div class="relative w-full h-[260px] overflow-hidden bg-[#050507]/60 border border-stone-950 flex items-center justify-center p-4">
                    
                    <!-- Premium Pill Badge -->
                    <span class="absolute top-3 left-3 z-20 px-2.5 py-1 text-[9px] font-bold uppercase tracking-widest bg-purple-500/10 border border-purple-500/20 text-purple-400">
                        75% OFF
                    </span>

                    <!-- IMAGE MATRIX: DUAL IMAGE CROSS FADE INTERACTION -->
                    <!-- Primary/Default View -->
                    <img src="https://via.placeholder.com/300x300/050507/e5c158?text=Primary+View" 
                         alt="Product Image" 
                         class="absolute w-full h-full object-contain p-6 transition-all duration-700 ease-in-out opacity-100 group-hover:opacity-0 group-hover:scale-105 z-10">
                    
                    <!-- Alternate/Hover Variant View -->
                    <img src="https://via.placeholder.com/300x300/050507/ffffff?text=Alternate+Angle" 
                         alt="Product Alternate View" 
                         class="absolute w-full h-full object-contain p-6 transition-all duration-700 ease-in-out opacity-0 group-hover:opacity-100 group-hover:scale-100 z-0">
                </div>

                <!-- Descriptive Metadata -->
                <div class="mt-5 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="text-sm font-medium tracking-wide text-white transition-colors duration-300 group-hover:text-[#e5c158]">Evo Luxury Audio</h3>
                        <p class="text-[11px] text-stone-500 tracking-wider mt-1 font-light">Quad Mic Acoustic System</p>
                        
                        <!-- Micro Variant Indicators (Interactive dots) -->
                        <div class="flex items-center gap-2 mt-3">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#3b2b52] border border-stone-800 cursor-pointer hover:border-white transition-colors"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-[#111111] border border-stone-800 cursor-pointer hover:border-white transition-colors"></span>
                        </div>
                    </div>

                    <!-- Price & Call to Action Matrix -->
                    <div class="mt-6 pt-4 border-t border-stone-950 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-stone-600 line-through tracking-wider">Rs.13,999</span>
                            <p class="text-sm font-semibold tracking-wider text-white">Rs.3,499</p>
                        </div>
                        
                        <!-- Action Trigger -->
                        <button class="px-4 py-2 bg-[#800000] hover:bg-[#600000] text-white text-[10px] font-medium tracking-widest uppercase transition-all duration-300 shadow-md">
                            Buy Now
                        </button>
                    </div>
                </div>
            </div>
            <!-- CORE PRODUCT CARD END -->

            <!-- Duplicated Placeholders for Agent Reference -->
            <!-- CARD 2 -->
            <div class="group relative w-full bg-[#0a0a0d]/40 border border-stone-900/80 p-5 flex flex-col transition-all duration-500 hover:border-stone-800 hover:bg-[#0a0a0d] hover:-translate-y-1">
                <div class="relative w-full h-[260px] overflow-hidden bg-[#050507]/60 border border-stone-950 flex items-center justify-center p-4">
                    <span class="absolute top-3 left-3 z-20 px-2.5 py-1 text-[9px] font-bold uppercase tracking-widest bg-stone-900 border border-stone-800 text-[#e5c158]">NEW ARRIVAL</span>
                    <img src="https://via.placeholder.com/300x300/050507/e5c158?text=Luna+Watch" class="absolute w-full h-full object-contain p-6 transition-all duration-700 ease-in-out opacity-100 group-hover:opacity-0 group-hover:scale-105 z-10">
                    <img src="https://via.placeholder.com/300x300/050507/ffffff?text=Luna+Side+Profile" class="absolute w-full h-full object-contain p-6 transition-all duration-700 ease-in-out opacity-0 group-hover:opacity-100 group-hover:scale-100 z-0">
                </div>
                <div class="mt-5 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="text-sm font-medium tracking-wide text-white transition-colors duration-300 group-hover:text-[#e5c158]">Luna Wearable</h3>
                        <p class="text-[11px] text-stone-500 tracking-wider mt-1 font-light">1.39" AMOLED Matrix Display</p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-stone-950 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-stone-600 line-through tracking-wider">Rs.21,999</span>
                            <p class="text-sm font-semibold tracking-wider text-white">Rs.5,999</p>
                        </div>
                        <button class="px-4 py-2 bg-[#800000] hover:bg-[#600000] text-white text-[10px] font-medium tracking-widest uppercase transition-all duration-300 shadow-md">Buy Now</button>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- 4. CINEMATIC VIDEO LOOP BANNER FRAME -->
    <section class="relative my-12 h-[50vh] min-h-[350px] bg-stone-950 flex items-center justify-center overflow-hidden border-y border-stone-900">
        <!-- Mask Overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#050507] via-[#050507]/70 to-[#050507] z-10"></div>
        
        <!-- Background Video/Visual Frame Container -->
        <div class="absolute inset-0 w-full h-full flex items-center justify-center text-stone-800 select-none">
            <span class="text-7xl font-black uppercase opacity-5 tracking-[0.2em]">VALENCIA LUXURY LABS</span>
        </div>

        <!-- Foreground Branding Content -->
        <div class="relative z-20 max-w-xl mx-auto text-center px-6 space-y-4">
            <span class="text-[10px] uppercase tracking-[0.4em] text-[#e5c158] font-bold block">Aesthetic Blueprint</span>
            <h2 class="text-2xl md:text-4xl font-light text-white uppercase tracking-widest">Designed for the Refined</h2>
            <p class="text-xs text-stone-400 font-light tracking-wide leading-relaxed">
                Watch our craft manifesto to discover how we process luxury watch elements and acoustic purity configurations.
            </p>
        </div>
    </section>

</div>
```

Ensure all variables are populated safely using Laravel Eloquent loops and dynamic model properties.