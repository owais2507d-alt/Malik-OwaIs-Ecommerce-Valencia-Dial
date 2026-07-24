<footer class="bg-[#050508] border-t border-white/5 relative overflow-hidden">
    {{-- Decorative top gradient line --}}
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-gold/20 to-transparent"></div>

    {{-- Top section with newsletter --}}
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 py-20 md:py-28">
        {{-- Brand + Newsletter row --}}
        <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-14 pb-16 border-b border-white/5">
            <div class="max-w-md">
                <a href="{{ url('/') }}" class="inline-flex items-baseline gap-2 group">
                    <span class="font-serif text-4xl font-bold tracking-[0.08em] gold">VALENCIA</span>
                    <span class="font-serif text-4xl font-light text-white/60">DIAL</span>
                </a>
                <p class="text-white/30 text-sm mt-5 leading-relaxed tracking-wide">Timeless elegance, crafted for those who appreciate the finer things in life. Curating the world's finest timepieces since 1987.</p>
                <div class="flex gap-4 mt-8">
                    <a href="#" class="w-11 h-11 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-white/40 hover:bg-gold hover:text-[#050508] hover:border-gold transition-all duration-300 text-sm"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="w-11 h-11 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-white/40 hover:bg-gold hover:text-[#050508] hover:border-gold transition-all duration-300 text-sm"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="w-11 h-11 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-white/40 hover:bg-gold hover:text-[#050508] hover:border-gold transition-all duration-300 text-sm"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="w-11 h-11 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-white/40 hover:bg-gold hover:text-[#050508] hover:border-gold transition-all duration-300 text-sm"><i class="fab fa-pinterest-p"></i></a>
                    <a href="#" class="w-11 h-11 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-white/40 hover:bg-gold hover:text-[#050508] hover:border-gold transition-all duration-300 text-sm"><i class="fab fa-x-twitter"></i></a>
                </div>
            </div>
            <div class="w-full lg:max-w-md">
                <h5 class="text-white/50 text-xs uppercase tracking-[4px] font-medium mb-5">Stay Informed</h5>
                <div class="flex gap-3">
                    <input type="email" placeholder="Enter your email"
                           class="flex-1 bg-white/5 border border-white/10 rounded-full px-6 py-4 text-sm text-white placeholder-white/20 focus:outline-none focus:border-gold/40 transition-all duration-300">
                    <button class="w-13 h-13 rounded-full bg-gold text-[#050508] flex items-center justify-center hover:bg-gold/90 transition-all duration-300 w-12 h-12"><i class="fas fa-arrow-right text-sm"></i></button>
                </div>
                <p class="text-white/20 text-xs mt-4 tracking-wide">Subscribe for exclusive drops and horology insights.</p>
            </div>
        </div>

        {{-- Links grid --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-12 py-16">
            <div>
                <h5 class="text-white/60 text-xs uppercase tracking-[4px] font-semibold mb-6">Shop</h5>
                <ul class="space-y-4">
                    <li><a href="{{ route('user.shop') }}" class="text-white/35 text-sm hover:text-gold transition-colors duration-300 tracking-wide">All Products</a></li>
                    <li><a href="{{ route('user.watches') }}" class="text-white/35 text-sm hover:text-gold transition-colors duration-300 tracking-wide">Watches</a></li>
                    <li><a href="{{ route('user.shop') }}" class="text-white/35 text-sm hover:text-gold transition-colors duration-300 tracking-wide">Luxury Collection</a></li>
                    <li><a href="{{ route('user.shop') }}" class="text-white/35 text-sm hover:text-gold transition-colors duration-300 tracking-wide">New Arrivals</a></li>
                    <li><a href="{{ route('user.shop') }}" class="text-white/35 text-sm hover:text-gold transition-colors duration-300 tracking-wide">Best Sellers</a></li>
                </ul>
            </div>
            <div>
                <h5 class="text-white/60 text-xs uppercase tracking-[4px] font-semibold mb-6">Support</h5>
                <ul class="space-y-4">
                    <li><a href="{{ route('user.contact') }}" class="text-white/35 text-sm hover:text-gold transition-colors duration-300 tracking-wide">Contact Us</a></li>
                    <li><a href="#" class="text-white/35 text-sm hover:text-gold transition-colors duration-300 tracking-wide">Shipping Info</a></li>
                    <li><a href="#" class="text-white/35 text-sm hover:text-gold transition-colors duration-300 tracking-wide">Returns & Exchanges</a></li>
                    <li><a href="#" class="text-white/35 text-sm hover:text-gold transition-colors duration-300 tracking-wide">Warranty</a></li>
                    <li><a href="#" class="text-white/35 text-sm hover:text-gold transition-colors duration-300 tracking-wide">FAQs</a></li>
                </ul>
            </div>
            <div>
                <h5 class="text-white/60 text-xs uppercase tracking-[4px] font-semibold mb-6">Company</h5>
                <ul class="space-y-4">
                    <li><a href="{{ route('user.about') }}" class="text-white/35 text-sm hover:text-gold transition-colors duration-300 tracking-wide">About Us</a></li>
                    <li><a href="{{ route('user.contact') }}" class="text-white/35 text-sm hover:text-gold transition-colors duration-300 tracking-wide">Careers</a></li>
                    <li><a href="#" class="text-white/35 text-sm hover:text-gold transition-colors duration-300 tracking-wide">Press</a></li>
                    <li><a href="#" class="text-white/35 text-sm hover:text-gold transition-colors duration-300 tracking-wide">Privacy Policy</a></li>
                    <li><a href="#" class="text-white/35 text-sm hover:text-gold transition-colors duration-300 tracking-wide">Terms of Service</a></li>
                </ul>
            </div>
            <div>
                <h5 class="text-white/60 text-xs uppercase tracking-[4px] font-semibold mb-6">Contact</h5>
                <ul class="space-y-4">
                    <li class="text-white/35 text-sm flex items-start gap-3 tracking-wide">
                        <i class="fas fa-map-marker-alt text-gold/60 text-xs mt-1"></i>
                        <span>Horology House, 64 Rue de la Paix, Paris</span>
                    </li>
                    <li class="text-white/35 text-sm flex items-center gap-3 tracking-wide">
                        <i class="fas fa-phone text-gold/60 text-xs"></i>
                        <a href="tel:+33123456789" class="hover:text-gold transition-colors">+33 1 23 45 67 89</a>
                    </li>
                    <li class="text-white/35 text-sm flex items-center gap-3 tracking-wide">
                        <i class="fas fa-envelope text-gold/60 text-xs"></i>
                        <a href="mailto:concierge@valenciadial.com" class="hover:text-gold transition-colors">concierge@valenciadial.com</a>
                    </li>
                    <li class="text-white/35 text-sm flex items-center gap-3 tracking-wide">
                        <i class="fas fa-clock text-gold/60 text-xs"></i>
                        <span>Mon–Sat: 10:00 – 19:00</span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="flex flex-col md:flex-row items-center justify-between gap-6 pt-10 border-t border-white/5">
            <div class="flex flex-wrap items-center gap-5">
                <span class="w-11 h-8 rounded bg-white/5 flex items-center justify-center text-white/30 text-sm"><i class="fab fa-cc-visa"></i></span>
                <span class="w-11 h-8 rounded bg-white/5 flex items-center justify-center text-white/30 text-sm"><i class="fab fa-cc-mastercard"></i></span>
                <span class="w-11 h-8 rounded bg-white/5 flex items-center justify-center text-white/30 text-sm"><i class="fab fa-cc-amex"></i></span>
                <span class="w-11 h-8 rounded bg-white/5 flex items-center justify-center text-white/30 text-sm"><i class="fab fa-cc-paypal"></i></span>
                <span class="w-11 h-8 rounded bg-white/5 flex items-center justify-center text-white/30 text-sm"><i class="fab fa-cc-apple-pay"></i></span>
            </div>
            <p class="text-white/20 text-xs tracking-[0.15em]">&copy; 2026 VALENCIA DIAL. All rights reserved.</p>
        </div>
    </div>
</footer>
