<header
        class="sticky top-0 z-50 bg-[#040405]/90 backdrop-blur-xl border-b border-stone-900/60 px-4 sm:px-6 lg:px-12 py-5 sm:py-6">
        <div class="max-w-1600px mx-auto flex items-center justify-between">

            <div class="flex-shrink-0">
                <a href="{{ url('/') }}"
                    class="luxury-title block text-xl sm:text-2xl tracking-[0.25em] text-stone-200 font-light smooth-transition hover:opacity-80 uppercase leading-none">
                    VALENCIA
                    <span
                        class="block text-[9px] sm:text-[10px] tracking-[0.45em] text-dark-gold font-semibold mt-1.5">DIAL</span>
                </a>
            </div>

            <nav
                class="hidden lg:flex items-center space-x-10 xl:space-x-14 text-[10px] uppercase tracking-[0.35em] font-medium">
                <a href="{{ route('user.home') }}" class="text-stone-200 hover-gold-glow smooth-transition">Home</a>
                <a href="{{ route('user.watches') }}" class="text-stone-400 hover-gold-glow smooth-transition">Watches</a>
                <a href="{{ route('user.shop') }}" class="text-stone-400 hover-gold-glow smooth-transition">All Products</a>
                <a href="{{ route('user.about') }}" class="text-stone-400 hover-gold-glow smooth-transition">About</a>
                <a href="{{ route('user.contact') }}" class="text-stone-400 hover-gold-glow smooth-transition">Contact</a>
            </nav>

            <div class="hidden lg:flex items-center space-x-8 text-[10px] uppercase tracking-[0.25em] font-light">
                <a href="{{ route('user.cart.index') }}" class="text-stone-300 hover:text-white smooth-transition flex items-center space-x-2 group">
                    <span class="tracking-[0.3em] group-hover:text-dark-gold smooth-transition">CART</span>
                    <span
                        class="text-dark-gold group-hover:text-stone-200 smooth-transition font-normal">({{ count(session('cart', [])) }})</span>
                </a>

                <span class="text-stone-800">|</span>

                @auth
                    <div class="flex items-center space-x-6">
                        <span class="text-stone-400">Vault: <span
                                class="text-dark-gold font-medium tracking-wider">{{ Auth::user()->name }}</span></span>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="text-stone-500 hover:text-red-400 smooth-transition font-medium tracking-widest">
                            Exit
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                    </div>
                @else
                    <div class="flex items-center space-x-4 font-medium">
                        <a href="{{ route('user.login') }}"
                            class="text-stone-400 hover:text-stone-100 smooth-transition">Login</a>
                        <span class="text-stone-800">/</span>
                        <a href="{{ route('user.register') }}"
                            class="text-stone-400 hover:text-stone-100 smooth-transition">Register</a>
                    </div>
                @endauth
            </div>

            <div class="flex items-center lg:hidden space-x-5">
                <a href="{{ route('user.cart.index') }}" class="text-[10px] tracking-[0.2em] text-stone-300 font-medium">
                    CART <span class="text-dark-gold">({{ count(session('cart', [])) }})</span>
                </a>

                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="text-stone-300 focus:outline-none p-1 cursor-pointer z-50">
                    <svg class="w-6 h-6 smooth-transition" fill="none" stroke="currentColor" stroke-width="1"
                        viewBox="0 0 24 24" x-show="!mobileMenuOpen">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5" />
                    </svg>
                    <svg class="w-6 h-6 smooth-transition" fill="none" stroke="currentColor" stroke-width="1"
                        viewBox="0 0 24 24" x-show="mobileMenuOpen" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="lg:hidden fixed inset-x-0 top-[73px] h-screen bg-[#040405]/98 backdrop-blur-2xl border-t border-stone-900/60 z-40 transition-all duration-300"
            x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4" style="display: none;">
            <div class="flex flex-col space-y-6 text-center tracking-[0.3em] text-[11px] uppercase pt-12 px-6">
                <a href="{{ route('user.home') }}" @click="mobileMenuOpen = false"
                    class="text-stone-200 py-2 border-b border-stone-900/40 hover:text-white">Home</a>
                <a href="{{ route('user.watches') }}" @click="mobileMenuOpen = false"
                    class="text-stone-400 py-2 border-b border-stone-900/40 hover:text-white">Watches</a>
                <a href="{{ route('user.shop') }}" @click="mobileMenuOpen = false"
                    class="text-stone-400 py-2 border-b border-stone-900/40 hover:text-white">All Products</a>
                <a href="{{ route('user.about') }}" @click="mobileMenuOpen = false"
                    class="text-stone-400 py-2 border-b border-stone-900/40 hover:text-white">About</a>
                <a href="{{ route('user.contact') }}" @click="mobileMenuOpen = false"
                    class="text-stone-400 py-2 border-b border-stone-900/40 hover:text-white">Contact</a>

                <div class="pt-6">
                    @auth
                        <p class="text-stone-500 text-[10px] mb-3 normal-case tracking-wide">Logged in as: <span
                                class="text-dark-gold font-medium">{{ Auth::user()->name }}</span></p>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();"
                            class="text-red-900/80 font-medium block py-2 tracking-widest text-[10px] border border-red-950/40 bg-red-950/10">Exit
                            Vault</a>
                        <form id="mobile-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf
                        </form>
                    @else
                        <div class="grid grid-cols-2 gap-4 pt-4">
                            <a href="{{ route('user.login') }}" class="btn-outline text-center py-3">
                                Login
                            </a>
                            <a href="{{ route('user.register') }}" class="btn-primary text-center py-3">
                                Register
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>