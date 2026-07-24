<header class="fixed top-0 left-0 w-full z-50 bg-[#0a0a0f]/95 backdrop-blur-md border-b border-white/5">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16 md:h-20">

      <a href="{{ url('/') }}" class="flex items-center gap-2 group">
        <span class="font-serif text-2xl md:text-3xl font-bold tracking-wider gold">VALENCIA</span>
        <span class="font-serif text-2xl md:text-3xl font-light text-white/80">DIAL</span>
      </a>

      <nav class="hidden lg:flex items-center gap-8 text-sm font-medium">
        <a href="{{ route('user.home') }}" class="nav-link text-white/80">HOME</a>
        <a href="{{ route('user.shop') }}" class="nav-link text-white/80">SHOP</a>
        <a href="{{ route('user.watches') }}" class="nav-link text-white/80">WATCHES</a>
        <a href="{{ route('user.about') }}" class="nav-link text-white/80">ABOUT</a>
        <a href="{{ route('user.contact') }}" class="nav-link text-white/80">CONTACT</a>
      </nav>

      <div class="flex items-center gap-3">
        @auth
        <span class="hidden lg:block text-white/40 text-xs tracking-wider">Welcome, <span class="gold">{{ Auth::user()->name }}</span></span>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('desktop-logout').submit();" class="hidden lg:inline-block text-[10px] uppercase tracking-[0.2em] text-white/40 hover:text-red-400 transition px-4 py-2 border border-white/5 rounded-full">LOGOUT</a>
        <form id="desktop-logout" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        @else
        <a href="{{ route('user.login') }}" class="hidden lg:inline-block text-[10px] uppercase tracking-[0.2em] text-white/80 hover:text-gold transition px-5 py-2 border border-white/10 rounded-full hover:border-gold">SIGN IN</a>
        <a href="{{ route('user.register') }}" class="hidden lg:inline-flex items-center text-[10px] uppercase tracking-[0.2em] font-semibold text-black bg-gradient-to-r from-[#d4af37] to-[#b8952e] px-5 py-2 rounded-full hover:shadow-lg hover:shadow-gold/20 transition-all">JOIN</a>
        @endauth

        <button id="menu-toggle" class="lg:hidden text-white/80 text-2xl focus:outline-none transition-transform duration-300 hover:scale-110">
          <i class="fas fa-bars"></i>
        </button>
      </div>

    </div>

    <div id="mobile-menu" class="lg:hidden hidden pb-6 border-t border-white/5 mt-2 pt-4">
      <nav class="flex flex-col gap-3 text-sm font-medium">
        <a href="{{ route('user.home') }}" class="text-white/80 hover:text-gold transition px-2 py-1.5">HOME</a>
        <a href="{{ route('user.shop') }}" class="text-white/80 hover:text-gold transition px-2 py-1.5">SHOP</a>
        <a href="{{ route('user.watches') }}" class="text-white/80 hover:text-gold transition px-2 py-1.5">WATCHES</a>
        <a href="{{ route('user.about') }}" class="text-white/80 hover:text-gold transition px-2 py-1.5">ABOUT</a>
        <a href="{{ route('user.contact') }}" class="text-white/80 hover:text-gold transition px-2 py-1.5">CONTACT</a>
        <div class="flex items-center gap-6 pt-3 border-t border-white/5 mt-1">
          @auth
            <span class="text-white/40 text-xs">Welcome, <span class="gold">{{ Auth::user()->name }}</span></span>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('mobile-logout').submit();" class="text-white/40 hover:text-red-400 transition text-xs">LOGOUT</a>
            <form id="mobile-logout" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
          @else
            <a href="{{ route('user.login') }}" class="gold-hover transition text-sm"><i class="fas fa-user"></i></a>

          @endauth
        </div>
      </nav>
    </div>
  </div>
</header>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    if (toggleBtn && mobileMenu) {
        toggleBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            mobileMenu.classList.toggle('hidden');
            const icon = this.querySelector('i');
            if (mobileMenu.classList.contains('hidden')) {
                icon.className = 'fas fa-bars';
            } else {
                icon.className = 'fas fa-times';
            }
        });
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                const icon = toggleBtn.querySelector('i');
                icon.className = 'fas fa-bars';
            });
        });
    }
});
</script>
@endpush
