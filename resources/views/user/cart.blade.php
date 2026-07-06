@extends('layouts.app')

@section('title', 'Cart — Valencia Dial')

@push('styles')
<style>
:root { --gold: #d4af37; }
body { background: #040405; color: #e4e4e7; }
.font-display { font-family: 'Cormorant Garamond', serif; }

.cart-item {
    background: #0a0a0e;
    border: 1px solid rgba(255,255,255,0.04);
    transition: all 0.4s ease;
}
.cart-item:hover {
    border-color: rgba(212,175,55,0.12);
}

.summary-card {
    background: #0a0a0e;
    border: 1px solid rgba(255,255,255,0.04);
    position: sticky;
    top: 100px;
}

.qty-btn {
    width: 32px; height: 32px;
    border-radius: 0;
    border: 1px solid rgba(255,255,255,0.08);
    background: transparent;
    color: #a1a1aa;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1rem;
}
.qty-btn:hover {
    border-color: var(--gold);
    color: var(--gold);
}
.qty-btn:disabled { opacity: 0.2; cursor: not-allowed; }

.gold-line {
    width: 2rem;
    height: 1px;
    background: rgba(212,175,55,0.3);
}

::-webkit-scrollbar { width: 4px; background: #0a0a0d; }
::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 20px; }
</style>
@endpush

@section('content')

<section class="min-h-screen py-20 md:py-28 px-4">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="mb-14 text-center" data-aos="fade-up">
            <p class="text-[0.5rem] tracking-[0.5em] uppercase text-[#d4af37]/70 font-medium mb-3">The Vault</p>
            <h1 class="font-display text-4xl md:text-6xl font-light text-white tracking-wide">
                Your <span class="text-[#d4af37]">Collection</span>
            </h1>
            <div class="w-10 h-px mx-auto mt-4" style="background: rgba(212,175,55,0.2);"></div>
        </div>

        @if(session('success'))
        <div class="max-w-lg mx-auto mb-8 text-center border border-emerald-900/30 bg-emerald-950/10 text-emerald-500 text-[0.5rem] uppercase tracking-widest py-3 px-5">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="max-w-lg mx-auto mb-8 text-center border border-red-900/30 bg-red-950/10 text-red-400 text-[0.5rem] uppercase tracking-widest py-3 px-5">
            {{ session('error') }}
        </div>
        @endif

        @if(count($cart) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Cart Items --}}
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart as $id => $item)
                <div class="cart-item p-5 flex flex-col sm:flex-row gap-5 items-start" data-aos="fade-up">
                    {{-- Image --}}
                    <div class="w-full sm:w-24 h-24 bg-[#050507] overflow-hidden flex-shrink-0 border border-white/[0.04]">
                        <img src="{{ $item['image'] ? asset('storage/' . $item['image']) : 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=200&h=200&fit=crop' }}"
                             alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                    </div>

                    {{-- Details --}}
                    <div class="flex-1 w-full">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-[0.45rem] tracking-[0.25em] uppercase text-stone-500 font-medium">{{ $item['brand'] ?? 'Valencia' }}</p>
                                <h3 class="text-sm text-white font-light tracking-wide mt-1">{{ $item['name'] }}</h3>
                            </div>
                            <span class="text-sm text-[#d4af37] font-light whitespace-nowrap">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                        </div>

                        <div class="flex items-center justify-between mt-4 pt-4 border-t border-white/[0.04]">
                            {{-- Quantity --}}
                            <div class="flex items-center gap-3">
                                <form action="{{ route('user.cart.update', $id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    <input type="hidden" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}">
                                    <button type="submit" class="qty-btn" {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>−</button>
                                </form>
                                <span class="w-8 text-center text-sm text-white tabular-nums">{{ $item['quantity'] }}</span>
                                <form action="{{ route('user.cart.update', $id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    <input type="hidden" name="quantity" value="{{ min($item['stock'], $item['quantity'] + 1) }}">
                                    <button type="submit" class="qty-btn" {{ $item['quantity'] >= $item['stock'] ? 'disabled' : '' }}>+</button>
                                </form>
                            </div>

                            <form action="{{ route('user.cart.remove', $id) }}" method="POST" onsubmit="return confirm('Remove this item?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-[0.45rem] tracking-[0.3em] uppercase text-stone-500 hover:text-red-400 transition-colors">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach

                {{-- Clear --}}
                <div class="text-center pt-4" data-aos="fade-up">
                    <form action="{{ route('user.cart.clear') }}" method="POST" onsubmit="return confirm('Clear entire collection?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-[0.45rem] tracking-[0.3em] uppercase text-stone-500 hover:text-red-400 transition-colors">Clear Collection</button>
                    </form>
                </div>
            </div>

            {{-- Summary --}}
            <div class="lg:col-span-1" data-aos="fade-up" data-aos-delay="100">
                <div class="summary-card p-6 md:p-8 space-y-6">
                    <p class="text-[0.5rem] tracking-[0.35em] uppercase text-stone-500 font-semibold">Order Summary</p>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between text-stone-400">
                            <span>Subtotal</span>
                            <span class="text-white">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-stone-400">
                            <span>Shipping</span>
                            <span class="text-[#d4af37] text-[0.4rem] uppercase tracking-widest">Calculated at checkout</span>
                        </div>
                        <div class="border-t border-white/[0.06] pt-3 flex justify-between text-base">
                            <span class="text-white">Total</span>
                            <span class="text-[#d4af37]">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <form action="{{ route('user.checkout') }}" method="GET">
                        <button type="submit" class="btn-primary w-full">Proceed to Checkout</button>
                    </form>

                    <div class="flex items-center justify-center gap-2 text-[0.35rem] tracking-[0.35em] uppercase text-stone-600">
                        <svg class="w-3 h-3 text-emerald-500/60" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <span>Secure Checkout</span>
                    </div>

                    <a href="{{ route('user.shop') }}" class="btn-ghost justify-center w-full pt-2">Continue Shopping</a>
                </div>
            </div>
        </div>

        @else
        {{-- Empty --}}
        <div class="text-center py-24" data-aos="fade-up">
            <div class="w-16 h-16 mx-auto mb-6 border border-white/[0.06] flex items-center justify-center">
                <svg class="w-6 h-6 text-stone-600" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                </svg>
            </div>
            <h2 class="text-xl font-light text-white tracking-wide mb-3">Your Vault is Empty</h2>
            <p class="text-stone-500 text-sm max-w-md mx-auto mb-8">Curated masterpieces await. Begin building your collection.</p>
            <a href="{{ route('user.shop') }}" class="btn-outline btn-lg">Explore Collection →</a>
        </div>
        @endif

    </div>
</section>

@endsection
