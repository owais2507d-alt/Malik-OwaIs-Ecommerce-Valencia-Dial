@if($slides->isNotEmpty())
<section class="relative w-full h-screen overflow-hidden bg-[#0a0a0f]">
    @foreach($slides as $index => $slide)
    <div class="carousel-slide absolute inset-0 w-full h-full {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
        <img src="{{ asset('storage/' . $slide->image) }}"
             alt="{{ $slide->title }}"
             class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-[#0a0a0f]/80 via-[#0a0a0f]/40 to-transparent"></div>
        <div class="relative z-10 h-full flex items-center max-w-7xl mx-auto px-6 sm:px-10 lg:px-16">
            <div class="max-w-2xl carousel-content py-12 md:py-16">
                @if($slide->subtitle)
                <span class="inline-block text-gold text-xs tracking-[5px] uppercase font-medium mb-3 carousel-subtitle">
                    {{ $slide->subtitle }}
                </span>
                <br>
                @endif
                <h1 class="font-serif font-bold text-white leading-[1.1] text-5xl md:text-7xl lg:text-8xl carousel-title">
                    {{ $slide->title }}
                </h1>
                @if($slide->description)
                <p class="text-base md:text-lg text-white/60 max-w-xl leading-relaxed font-light tracking-wide mt-5 carousel-desc">
                    {{ $slide->description }}
                </p>
                <br>
                @endif
                @if($slide->cta_text && $slide->cta_link)
                <div class="mt-8 carousel-cta">
                    <a href="{{ $slide->cta_link }}" class="btn-primary inline-flex items-center justify-center gap-3 px-8 py-4 text-sm font-semibold tracking-wider uppercase min-h-[52px]">
                        <span>{{ $slide->cta_text }}</span> 
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach

    @if($slides->count() > 1)
    <button onclick="prevSlide()" class="carousel-nav carousel-prev" aria-label="Previous slide">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button onclick="nextSlide()" class="carousel-nav carousel-next" aria-label="Next slide">
        <i class="fas fa-chevron-right"></i>
    </button>

    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-20 flex items-center gap-3">
        @foreach($slides as $index => $slide)
        <button onclick="goToSlide({{ $index }})"
                class="carousel-dot {{ $index === 0 ? 'active' : '' }}"
                aria-label="Go to slide {{ $index + 1 }}"></button>
        @endforeach
    </div>
    @endif
</section>


@push('scripts')
<script>
    (function() {
        const slides = document.querySelectorAll('.carousel-slide');
        const dots = document.querySelectorAll('.carousel-dot');
        let currentSlide = 0;
        let autoPlayInterval;

        function showSlide(index) {
            slides.forEach((s, i) => {
                s.classList.toggle('active', i === index);
            });
            dots.forEach((d, i) => {
                d.classList.toggle('active', i === index);
            });
            currentSlide = index;
        }

        window.nextSlide = function() {
            showSlide((currentSlide + 1) % slides.length);
            resetAutoPlay();
        };

        window.prevSlide = function() {
            showSlide((currentSlide - 1 + slides.length) % slides.length);
            resetAutoPlay();
        };

        window.goToSlide = function(index) {
            showSlide(index);
            resetAutoPlay();
        };

        function resetAutoPlay() {
            clearInterval(autoPlayInterval);
            autoPlayInterval = setInterval(nextSlide, 6000);
        }

        if (slides.length > 1) {
            autoPlayInterval = setInterval(nextSlide, 6000);
        }
    })();
</script>
@endpush
@endif
