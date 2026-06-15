@extends('layouts.shop')

@section('title', 'Your Secure Cart Vault | Valencia Dial')

@section('content')
<div class="min-h-[75vh] bg-[#040405] text-stone-300 py-12 lg:py-20 px-6 lg:px-16">
    <div class="max-w-[1200px] mx-auto space-y-12">
        
        <div class="text-center sm:text-left space-y-2">
            <p class="text-[10px] uppercase tracking-[0.4em] text-dark-gold font-medium">Bespoke Allocations</p>
            <h1 class="luxury-title text-3xl sm:text-4xl font-light tracking-[0.15em] text-stone-100 uppercase">Your Vault Session</h1>
            <div class="w-12 h-[1px] bg-dark-gold opacity-30 mt-3 hidden sm:block"></div>
        </div>

        @if(count($cart) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                
                <div class="lg:col-span-8 space-y-4">
                    @php $totalPrice = 0; @endphp
                    
                    @foreach($cart as $id => $item)
                        @php $totalPrice += $item['price']; @endphp
                        
                        <div class="flex flex-col sm:flex-row items-center justify-between border border-stone-900/60 bg-stone-950/20 p-6 gap-6 smooth-transition hover:border-stone-800">
                            
                            <div class="flex flex-col sm:flex-row items-center text-center sm:text-left gap-6 w-full sm:w-auto">
                                <div class="w-20 h-20 bg-stone-950 flex-shrink-0 border border-stone-900/40 p-1 flex items-center justify-center">
                                    @if(isset($item['image']))
                                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="max-h-full max-w-full object-contain">
                                    @else
                                        <div class="text-[8px] uppercase tracking-widest text-stone-700">No Image</div>
                                    @endif
                                </div>
                                <div class="space-y-1">
                                    <p class="text-[9px] uppercase tracking-[0.3em] text-dark-gold font-medium">{{ $item['brand'] ?? 'Haute Horology' }}</p>
                                    <h3 class="text-sm font-medium tracking-wide text-stone-200 uppercase">{{ $item['name'] }}</h3>
                                    <p class="text-[10px] text-stone-600 font-light tracking-wider">Ref: {{ $item['reference'] }}</p>
                                </div>
                            </div>

                            <div class="flex sm:flex-col items-center sm:items-end justify-between sm:justify-center w-full sm:w-auto border-t sm:border-t-0 border-stone-900/40 pt-4 sm:pt-0 gap-2">
                                <div class="text-sm tracking-widest text-stone-300 font-light">
                                    ${{ number_format($item['price'], 2) }}
                                </div>
                                
                                <form action="{{ route('cart.remove', $id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-[9px] uppercase tracking-[0.2em] text-red-900/80 hover:text-red-400 smooth-transition font-medium pt-1 cursor-pointer">
                                        [Revoke Allocation]
                                    </button>
                                </form>
                            </div>

                        </div>
                    @endforeach
                </div>

                <div class="lg:col-span-4 border border-stone-900/60 bg-stone-950/40 p-6 space-y-6">
                    <h4 class="text-[10px] uppercase tracking-[0.3em] text-stone-400 font-semibold border-b border-stone-900/40 pb-3">
                        Summary Ledger
                    </h4>
                    
                    <div class="space-y-3 text-xs tracking-wider font-light">
                        <div class="flex justify-between text-stone-500">
                            <span>Selected Pieces</span>
                            <span>{{ count($cart) }}</span>
                        </div>
                        <div class="flex justify-between text-stone-500">
                            <span>Secured Logistics</span>
                            <span class="text-dark-gold uppercase text-[10px] tracking-widest">Complimentary</span>
                        </div>
                        <hr class="border-stone-900/40 my-2">
                        <div class="flex justify-between items-baseline text-stone-200 pt-1">
                            <span class="text-xs uppercase tracking-widest">Total Vault Value</span>
                            <span class="text-lg tracking-widest font-normal text-white">${{ number_format($totalPrice, 2) }}</span>
                        </div>
                    </div>

                    <div class="pt-4 space-y-3">
                        <a href="#" class="block w-full text-[10px] uppercase tracking-[0.3em] font-bold py-4 px-6 text-black transition-all duration-300 hover:opacity-90 text-center font-semibold" style="background-color: var(--color-dark-gold);">
                            Proceed to Secure Checkout
                        </a>
                        <a href="{{ route('shop.index') }}" class="block w-full text-[9px] uppercase tracking-[0.25em] text-stone-500 hover:text-stone-300 text-center smooth-transition font-light pt-2">
                            Continue Exploring Showroom
                        </a>
                    </div>
                </div>

            </div>
        @else
            <div class="border border-stone-900/40 bg-stone-950/10 py-24 px-6 text-center space-y-6">
                <div class="absolute w-[200px] h-[200px] opacity-5 blur-[80px] rounded-full left-1/2 transform -translate-x-1/2 pointer-events-none" style="background-color: var(--color-dark-gold);"></div>
                
                <p class="luxury-title text-stone-600 text-xl tracking-widest lowercase italic">your private session vault is empty.</p>
                <p class="text-stone-500 font-light text-xs tracking-widest max-w-md mx-auto leading-relaxed">
                    No horological assets have been allocated for purchase yet. Return to our boutique catalogue to view available mechanical models.
                </p>
                <div class="pt-4">
                    <a href="{{ route('shop.index') }}" class="inline-block text-[10px] uppercase tracking-[0.25em] font-medium py-3.5 px-8 bg-[#040405] text-dark-gold border border-dark-gold smooth-transition hover:bg-stone-950 font-semibold">
                        View Available Watches
                    </a>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection