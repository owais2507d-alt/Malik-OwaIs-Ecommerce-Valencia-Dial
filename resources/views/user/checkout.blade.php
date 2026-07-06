@extends('layouts.app')

@section('title', 'Checkout — Valencia Dial')

@push('styles')
<style>
:root { --gold: #d4af37; }
body { background: #040405; color: #e4e4e7; }
.font-display { font-family: 'Cormorant Garamond', serif; }

.form-input {
    width: 100%;
    padding: 0.75rem 1rem;
    background: #0a0a0e;
    border: 1px solid rgba(255,255,255,0.06);
    color: #e4e4e7;
    font-size: 0.85rem;
    outline: none;
    transition: all 0.3s ease;
}
.form-input:focus { border-color: rgba(212,175,55,0.25); background: #111; }
.form-input::placeholder { color: #555; }
.form-input.error { border-color: rgba(239,68,68,0.3); }
.form-label { display: block; font-size: 0.5rem; text-transform: uppercase; letter-spacing: 0.2em; color: #a1a1aa; margin-bottom: 0.4rem; }

.step-circle {
    width: 36px; height: 36px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.7rem; font-weight: 500;
    border: 1px solid rgba(255,255,255,0.1);
    color: #666;
    transition: all 0.4s ease;
}
.step-circle.active { border-color: var(--gold); background: var(--gold); color: #0a0a0d; }
.step-circle.done { border-color: #10b981; background: #10b981; color: white; }
.step-line { width: 40px; height: 1px; background: rgba(255,255,255,0.06); margin: 0 6px; transition: all 0.4s ease; }
.step-line.done { background: #10b981; }
.step-label { font-size: 0.45rem; text-transform: uppercase; letter-spacing: 0.2em; color: #666; text-align: center; transition: all 0.3s ease; }
.step-label.active { color: var(--gold); }
.step-label.done { color: #10b981; }

.step-content { display: none; animation: fadeIn 0.4s ease; }
.step-content.active { display: block; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }

.payment-card {
    background: #0a0a0e;
    border: 1px solid rgba(255,255,255,0.05);
    padding: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
}
.payment-card:hover { border-color: rgba(212,175,55,0.15); }
.payment-card.selected { border-color: var(--gold); background: rgba(212,175,55,0.04); }

[x-cloak] { display: none !important; }
::-webkit-scrollbar { width: 4px; background: #0a0a0d; }
::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 20px; }
</style>
@endpush

@section('content')

<section class="min-h-screen py-20 md:py-28 px-4" x-data="checkoutSteps()">
    <div class="max-w-6xl mx-auto">

        {{-- Header --}}
        <div class="mb-12 text-center" data-aos="fade-up">
            <p class="text-[0.5rem] tracking-[0.5em] uppercase text-[#d4af37]/70 font-medium mb-3">Secure Checkout</p>
            <h1 class="font-display text-4xl md:text-6xl font-light text-white tracking-wide">
                Finalize Your <span class="text-[#d4af37]">Order</span>
            </h1>
            <div class="w-10 h-px mx-auto mt-4" style="background: rgba(212,175,55,0.2);"></div>
        </div>

        {{-- Steps --}}
        <div class="mb-12" data-aos="fade-up">
            <div class="flex items-center justify-center">
                <template x-for="(s, i) in steps" :key="i">
                    <div class="flex flex-col items-center">
                        <div class="flex items-center">
                            <div class="step-circle" :class="{ 'active': currentStep === i, 'done': currentStep > i }" x-text="currentStep > i ? '✓' : (i + 1)"></div>
                            <template x-if="i < steps.length - 1">
                                <div class="step-line" :class="{ 'done': currentStep > i }"></div>
                            </template>
                        </div>
                        <span class="step-label pt-2" :class="{ 'active': currentStep === i, 'done': currentStep > i }" x-text="s"></span>
                    </div>
                </template>
            </div>
        </div>

        <form action="{{ route('user.checkout.place') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

                {{-- Left: Steps --}}
                <div class="lg:col-span-3 space-y-6" data-aos="fade-up">

                    {{-- Step 1: Shipping --}}
                    <div class="step-content" :class="{ 'active': currentStep === 0 }">
                        <div class="bg-[#0a0a0e] border border-white/[0.04] p-6 md:p-8 space-y-5">
                            <div class="mb-6">
                                <h3 class="text-sm text-white font-medium">Shipping Details</h3>
                                <p class="text-[0.45rem] tracking-[0.25em] uppercase text-stone-500 mt-1">Where should we deliver?</p>
                                <div class="w-8 h-px mt-3" style="background: rgba(212,175,55,0.2);"></div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="shipping_name" class="form-input" placeholder="Alexander Hamilton" required>
                                </div>
                                <div>
                                    <label class="form-label">Phone</label>
                                    <input type="tel" name="phone" class="form-input" placeholder="+1 (555) 000-0000" required>
                                </div>
                            </div>

                            <div>
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-input" placeholder="123 Luxury Avenue, Suite 100" required>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                <div>
                                    <label class="form-label">City</label>
                                    <input type="text" name="city" class="form-input" placeholder="New York" required>
                                </div>
                                <div>
                                    <label class="form-label">Postal Code</label>
                                    <input type="text" name="postal_code" class="form-input" placeholder="10001">
                                </div>
                                <div>
                                    <label class="form-label">Country</label>
                                    <input type="text" name="country" class="form-input" placeholder="United States" required>
                                </div>
                            </div>

                            <div class="pt-4 flex justify-end">
                                <button type="button" @click="nextStep()" class="btn-primary px-10 w-auto">
                                    Continue to Payment
                                    <svg class="w-3 h-3 ml-2 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Step 2: Payment --}}
                    <div class="step-content" :class="{ 'active': currentStep === 1 }">
                        <div class="bg-[#0a0a0e] border border-white/[0.04] p-6 md:p-8 space-y-5">
                            <div class="mb-6">
                                <h3 class="text-sm text-white font-medium">Payment Method</h3>
                                <p class="text-[0.45rem] tracking-[0.25em] uppercase text-stone-500 mt-1">Choose your preference</p>
                                <div class="w-8 h-px mt-3" style="background: rgba(212,175,55,0.2);"></div>
                            </div>

                            <div class="space-y-3">
                                <label class="payment-card flex items-center gap-4" :class="{ 'selected': selectedPayment === 'cod' }" @click="selectedPayment = 'cod'">
                                    <input type="radio" name="payment_method" value="cod" x-model="selectedPayment" class="sr-only">
                                    <div class="flex-1">
                                        <span class="text-sm text-white">Cash on Delivery</span>
                                        <p class="text-[0.4rem] uppercase tracking-widest text-stone-500 mt-0.5">Pay when you receive</p>
                                    </div>
                                    <div class="w-4 h-4 rounded-full border" :class="{ 'border-gold': selectedPayment === 'cod', 'border-white/[0.15]': selectedPayment !== 'cod' }">
                                        <div x-show="selectedPayment === 'cod'" class="w-2 h-2 rounded-full bg-[#d4af37] mx-auto mt-[3px]"></div>
                                    </div>
                                </label>

                                <label class="payment-card flex items-center gap-4" :class="{ 'selected': selectedPayment === 'stripe' }" @click="selectedPayment = 'stripe'">
                                    <input type="radio" name="payment_method" value="stripe" x-model="selectedPayment" class="sr-only">
                                    <div class="flex-1">
                                        <span class="text-sm text-white">Credit Card <span class="text-[0.4rem] uppercase tracking-widest text-[#d4af37]">(Stripe)</span></span>
                                        <p class="text-[0.4rem] uppercase tracking-widest text-stone-500 mt-0.5">Secure payment by Stripe</p>
                                    </div>
                                    <div class="w-4 h-4 rounded-full border" :class="{ 'border-gold': selectedPayment === 'stripe', 'border-white/[0.15]': selectedPayment !== 'stripe' }">
                                        <div x-show="selectedPayment === 'stripe'" class="w-2 h-2 rounded-full bg-[#d4af37] mx-auto mt-[3px]"></div>
                                    </div>
                                </label>
                            </div>

                            <div x-show="selectedPayment === 'stripe'" x-cloak class="bg-[#050507] border border-white/[0.04] p-5 space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-[0.45rem] tracking-[0.2em] uppercase text-stone-500">Card Details</span>
                                    <div class="flex gap-2 text-[0.45rem] text-white font-medium">
                                        <span>VISA</span>
                                        <span>MC</span>
                                    </div>
                                </div>
                                <input type="text" placeholder="4242 4242 4242 4242" class="form-input text-sm tracking-widest font-mono" disabled>
                                <div class="grid grid-cols-2 gap-4">
                                    <input type="text" placeholder="MM / YY" class="form-input text-sm" disabled>
                                    <input type="text" placeholder="CVC" class="form-input text-sm" disabled>
                                </div>
                                <p class="text-[0.35rem] uppercase tracking-widest text-emerald-500/60 flex items-center gap-2">
                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    PCI Compliant — Test Mode
                                </p>
                            </div>

                            <div class="flex items-center justify-between pt-4">
                                <button type="button" @click="prevStep()" class="btn-outline flex items-center gap-2">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg>
                                    Back
                                </button>
                                <button type="button" @click="nextStep()" class="btn-primary px-10 w-auto">
                                    Review Order
                                    <svg class="w-3 h-3 ml-2 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Step 3: Review --}}
                    <div class="step-content" :class="{ 'active': currentStep === 2 }">
                        <div class="bg-[#0a0a0e] border border-white/[0.04] p-6 md:p-8 space-y-5">
                            <div class="mb-6">
                                <h3 class="text-sm text-white font-medium">Review Your Order</h3>
                                <p class="text-[0.45rem] tracking-[0.25em] uppercase text-stone-500 mt-1">Confirm everything is correct</p>
                                <div class="w-8 h-px mt-3" style="background: rgba(212,175,55,0.2);"></div>
                            </div>

                            <div class="bg-[#050507] p-5 border border-white/[0.04]">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-[0.45rem] tracking-[0.2em] uppercase text-[#d4af37]">Shipping To</span>
                                    <button type="button" @click="currentStep = 0" class="text-[0.35rem] tracking-[0.3em] uppercase text-stone-500 hover:text-[#d4af37] transition-colors">Edit</button>
                                </div>
                                <p class="text-sm text-white" id="review-name"></p>
                                <p class="text-xs text-stone-400" id="review-address"></p>
                                <p class="text-xs text-stone-400" id="review-city"></p>
                            </div>

                            <div class="bg-[#050507] p-5 border border-white/[0.04]">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-[0.45rem] tracking-[0.2em] uppercase text-[#d4af37]">Payment</span>
                                    <button type="button" @click="currentStep = 1" class="text-[0.35rem] tracking-[0.3em] uppercase text-stone-500 hover:text-[#d4af37] transition-colors">Edit</button>
                                </div>
                                <p class="text-sm text-white" x-text="selectedPayment === 'cod' ? 'Cash on Delivery' : 'Credit Card (Stripe)'"></p>
                                <p class="text-xs text-stone-400">Payable: <span class="text-[#d4af37]">${{ number_format($total, 2) }}</span></p>
                            </div>

                            <div class="flex items-center justify-between pt-4">
                                <button type="button" @click="prevStep()" class="btn-outline flex items-center gap-2">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg>
                                    Back
                                </button>
                                <button type="submit" class="btn-primary px-10 w-auto">
                                    Place Order
                                    <svg class="w-3 h-3 ml-2 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right: Order Summary --}}
                <div class="lg:col-span-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-[#0a0a0e] border border-white/[0.04] p-6 md:p-8 sticky top-24 space-y-5">
                        <p class="text-[0.5rem] tracking-[0.35em] uppercase text-stone-500 font-semibold">Order Summary</p>

                        <div class="space-y-3 max-h-72 overflow-y-auto pr-1">
                            @foreach($cart as $id => $item)
                            <div class="flex items-center gap-3 p-3 bg-[#050507] border border-white/[0.04]">
                                <div class="w-12 h-12 bg-[#050507] overflow-hidden flex-shrink-0">
                                    <img src="{{ $item['image'] ? asset('storage/' . $item['image']) : 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=100&h=100&fit=crop' }}" alt="" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-white truncate font-light">{{ $item['name'] }}</p>
                                    <p class="text-[0.35rem] uppercase tracking-widest text-stone-500 mt-0.5">Qty: {{ $item['quantity'] }}</p>
                                </div>
                                <span class="text-sm text-[#d4af37] font-light whitespace-nowrap">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                            </div>
                            @endforeach
                        </div>

                        <div class="border-t border-white/[0.06] pt-4 space-y-3 text-sm">
                            <div class="flex justify-between text-stone-400">
                                <span>Subtotal</span>
                                <span class="text-white">${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-stone-400">
                                <span>Shipping</span>
                                <span class="text-[#d4af37] text-[0.4rem] uppercase tracking-widest">Free</span>
                            </div>
                            <div class="border-t border-white/[0.06] pt-3 flex justify-between text-base">
                                <span class="text-white">Total</span>
                                <span class="text-[#d4af37] text-lg">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        {{-- Coupon --}}
                        <div class="flex gap-2">
                            <input type="text" placeholder="Coupon code" class="flex-1 bg-[#050507] border border-white/[0.06] px-4 py-2.5 text-sm text-white outline-none focus:border-[#d4af37]/30 transition-all placeholder:text-stone-600">
                            <button type="button" class="btn-outline">Apply</button>
                        </div>

                        {{-- Trust --}}
                        <div class="pt-2 space-y-2">
                            <div class="flex items-center gap-2 text-[0.35rem] uppercase tracking-[0.35em] text-stone-600">
                                <svg class="w-2.5 h-2.5 text-emerald-500/60" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span>SSL Encrypted</span>
                            </div>
                            <div class="flex items-center gap-2 text-[0.35rem] uppercase tracking-[0.35em] text-stone-600">
                                <svg class="w-2.5 h-2.5 text-emerald-500/60" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                <span>Authentic Guaranteed</span>
                            </div>
                            <div class="flex items-center gap-2 text-[0.35rem] uppercase tracking-[0.35em] text-stone-600">
                                <svg class="w-2.5 h-2.5 text-emerald-500/60" fill="currentColor" viewBox="0 0 20 20"><path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/><path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3z"/></svg>
                                <span>Free Express Shipping</span>
                            </div>
                        </div>

                        <a href="{{ route('user.cart.index') }}" class="btn-ghost justify-center w-full pt-2">← Edit Cart</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
function checkoutSteps() {
    return {
        currentStep: 0,
        selectedPayment: 'cod',
        steps: ['Shipping', 'Payment', 'Review'],
        nextStep() {
            if (this.currentStep < this.steps.length - 1) {
                const inputs = document.querySelectorAll(`.step-content.active input[required]`);
                let valid = true;
                inputs.forEach(i => { if (!i.value) valid = false; });
                if (this.currentStep === 0 && !valid) {
                    inputs.forEach(i => { if (!i.value) i.classList.add('error'); });
                    return;
                }
                inputs.forEach(i => i.classList.remove('error'));
                this.currentStep++;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        },
        prevStep() {
            if (this.currentStep > 0) {
                this.currentStep--;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        },
        init() {
            this.$watch('currentStep', () => {
                if (this.currentStep === 2) this.populateReview();
            });
        },
        populateReview() {
            const form = document.querySelector('form');
            document.getElementById('review-name').textContent = form.querySelector('[name="shipping_name"]').value || '—';
            document.getElementById('review-address').textContent = form.querySelector('[name="address"]').value || '—';
            const city = form.querySelector('[name="city"]').value || '';
            const country = form.querySelector('[name="country"]').value || '';
            document.getElementById('review-city').textContent = [city, country].filter(Boolean).join(', ') || '—';
        }
    }
}
</script>
@endsection
