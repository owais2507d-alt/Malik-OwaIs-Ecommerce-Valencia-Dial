<section class="relative min-h-[50vh] md:min-h-[60vh] flex items-center justify-center overflow-hidden bg-[#0a0a0f]">
    {{-- Decorative elements --}}
    <div class="absolute top-1/2 left-1/3 w-px h-40 bg-gradient-to-b from-transparent via-gold/10 to-transparent"></div>
    <div class="absolute top-1/2 right-1/3 w-px h-40 bg-gradient-to-b from-transparent via-gold/10 to-transparent"></div>
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: repeating-linear-gradient(45deg, #d4af37 0px, #d4af37 1px, transparent 1px, transparent 40px);"></div>

    {{-- Content --}}
    <div class="relative z-10 w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20 text-center">
        {{-- Badge --}}
        <div class="inline-flex items-center gap-2 bg-gold/10 border border-gold/20 rounded-full px-4 py-1.5 mb-6" data-aos="fade-up">
            <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
            <span class="text-gold text-xs uppercase tracking-[3px] font-medium">{{ $activeDeal->badge_text ?? 'Limited Time' }}</span>
        </div>

        {{-- Title --}}
        <h2 class="font-serif font-bold text-white text-4xl md:text-5xl lg:text-6xl leading-tight" data-aos="fade-up" data-aos-delay="100">
            {{ $activeDeal->title }}
        </h2>

        {{-- Description --}}
        @if($activeDeal->description)
        <p class="text-white/50 text-base md:text-lg font-light mt-4 max-w-2xl mx-auto leading-relaxed" data-aos="fade-up" data-aos-delay="150">
            {{ $activeDeal->description }}
        </p>
        @endif

        {{-- Countdown --}}
        <div class="flex items-center justify-center gap-3 sm:gap-6 mt-8" data-aos="fade-up" data-aos-delay="200" id="dealCountdown">
            <div class="flex flex-col items-center bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl px-4 py-3 min-w-[72px] sm:px-5 sm:py-4 sm:min-w-[80px]">
                <span class="text-3xl md:text-4xl font-serif font-bold gold leading-none" id="deal-weeks">00</span>
                <span class="text-[10px] uppercase tracking-[2px] text-white/30 mt-2">Weeks</span>
            </div>
            <span class="text-2xl md:text-3xl font-light text-gold/30">:</span>
            <div class="flex flex-col items-center bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl px-4 py-3 min-w-[72px] sm:px-5 sm:py-4 sm:min-w-[80px]">
                <span class="text-3xl md:text-4xl font-serif font-bold gold leading-none" id="deal-days">00</span>
                <span class="text-[10px] uppercase tracking-[2px] text-white/30 mt-2">Days</span>
            </div>
            <span class="text-2xl md:text-3xl font-light text-gold/30">:</span>
            <div class="flex flex-col items-center bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl px-4 py-3 min-w-[72px] sm:px-5 sm:py-4 sm:min-w-[80px]">
                <span class="text-3xl md:text-4xl font-serif font-bold gold leading-none" id="deal-hours">00</span>
                <span class="text-[10px] uppercase tracking-[2px] text-white/30 mt-2">Hours</span>
            </div>
            <span class="text-2xl md:text-3xl font-light text-gold/30">:</span>
            <div class="flex flex-col items-center bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl px-4 py-3 min-w-[72px] sm:px-5 sm:py-4 sm:min-w-[80px]">
                <span class="text-3xl md:text-4xl font-serif font-bold gold leading-none" id="deal-minutes">00</span>
                <span class="text-[10px] uppercase tracking-[2px] text-white/30 mt-2">Mins</span>
            </div>
            <span class="text-2xl md:text-3xl font-light text-gold/30">:</span>
            <div class="flex flex-col items-center bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl px-4 py-3 min-w-[72px] sm:px-5 sm:py-4 sm:min-w-[80px]">
                <span class="text-3xl md:text-4xl font-serif font-bold gold leading-none" id="deal-seconds">00</span>
                <span class="text-[10px] uppercase tracking-[2px] text-white/30 mt-2">Secs</span>
            </div>
        </div>
        <br>

        {{-- CTA --}}
        @if($activeDeal->cta_text && $activeDeal->cta_link)
        <div class="mt-10" data-aos="fade-up" data-aos-delay="250">
            <a href="{{ $activeDeal->cta_link }}" class="btn-premium inline-flex items-center justify-center gap-3 px-8 py-4 text-sm font-semibold tracking-wider uppercase min-h-[52px]">
                <span>{{ $activeDeal->cta_text }}</span>
                <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
    (function() {
        const endDate = new Date('{{ $activeDeal->end_date->format('Y-m-d H:i:s') }}').getTime();

        function updateCountdown() {
            const now = new Date().getTime();
            const diff = endDate - now;

            if (diff <= 0) {
                document.getElementById('dealCountdown').innerHTML = '<span class="text-gold text-sm uppercase tracking-[2px] font-medium">Deal has ended</span>';
                return;
            }

            const totalSeconds = Math.floor(diff / 1000);
            const weeks = Math.floor(totalSeconds / (7 * 24 * 60 * 60));
            const days = Math.floor((totalSeconds % (7 * 24 * 60 * 60)) / (24 * 60 * 60));
            const hours = Math.floor((totalSeconds % (24 * 60 * 60)) / (60 * 60));
            const minutes = Math.floor((totalSeconds % (60 * 60)) / 60);
            const seconds = totalSeconds % 60;

            document.getElementById('deal-weeks').textContent = String(weeks).padStart(2, '0');
            document.getElementById('deal-days').textContent = String(days).padStart(2, '0');
            document.getElementById('deal-hours').textContent = String(hours).padStart(2, '0');
            document.getElementById('deal-minutes').textContent = String(minutes).padStart(2, '0');
            document.getElementById('deal-seconds').textContent = String(seconds).padStart(2, '0');
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    })();
</script>
@endpush
