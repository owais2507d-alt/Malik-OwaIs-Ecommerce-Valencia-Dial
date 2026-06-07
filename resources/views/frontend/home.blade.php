<p class="text-white font-medium tracking-wide uppercase text-sm">
    {{ Auth::user()->name }}
</p>
<br>
<p class="text-white font-medium tracking-wide uppercase text-sm">
    {{ Auth::user()->email }}
</p>

<br>
<!-- Premium Logout Button Element -->
<form action="{{ route('logout') }}" method="POST" class="inline-block">
    @csrf
    <button type="submit" class="border border-stone-800 hover:border-[#d4af37]/40 text-stone-400 hover:text-[#d4af37] text-[11px] uppercase tracking-[0.2em] px-4 py-2 bg-transparent transition duration-300 ease-in-out font-medium rounded-none cursor-pointer">
        Sign Out
    </button>
</form>