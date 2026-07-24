@extends('layouts.app')

@section('title', 'Shop — Valencia Dial')

@section('content')

{{-- ===== INLINE STYLES FOR PREMIUM FILTER UI ===== --}}
<style>
    /* ---------- Filter Buttons ---------- */
    .filter-btn {
        @apply px-4 py-2.5 text-[11px] uppercase tracking-[0.1em] border border-white/10 rounded-full text-white/50 hover:text-white hover:border-white/30 transition-all duration-300;
    }
    .filter-btn.active {
        @apply border-gold text-gold bg-gold/5;
    }

    /* ---------- Advanced Search ---------- */
    .search-wrapper {
        transition: all 0.3s ease;
    }
    .search-wrapper:focus-within .search-icon {
        color: #d4af37;
    }
    .search-input {
        transition: border-color 0.3s, background 0.3s, box-shadow 0.3s;
    }
    .search-input:focus {
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15), inset 0 0 0 1px rgba(212, 175, 55, 0.3);
    }
    .clear-search {
        transition: opacity 0.2s, transform 0.2s;
        cursor: pointer;
    }
    .clear-search.show {
        display: block;
    }

    /* ---------- Custom Sort Dropdown ---------- */
    .sort-dropdown {
        position: relative;
    }
    .sort-toggle {
        min-width: 110px;
        justify-content: space-between;
    }
    .sort-toggle .sort-arrow {
        transition: transform 0.3s ease;
    }
    .sort-dropdown.open .sort-arrow {
        transform: rotate(180deg);
    }
    .sort-menu {
        transform-origin: top right;
        animation: slideDown 0.25s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
    }
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: scaleY(0.92) translateY(-8px);
        }
        to {
            opacity: 1;
            transform: scaleY(1) translateY(0);
        }
    }
    .sort-option {
        border-bottom: 1px solid rgba(255,255,255,0.04);
    }
    .sort-option:last-child {
        border-bottom: none;
    }
    .sort-option:hover {
        background: rgba(212, 175, 55, 0.08);
    }
    .sort-option.text-gold {
        background: rgba(212, 175, 55, 0.1);
    }
</style>

{{-- ===== HERO / PAGE HEADER ===== --}}
<section class="relative min-h-[70vh] flex items-center justify-center overflow-hidden border-b border-white/5 px-4 py-20 md:py-28">
    <div class="relative z-10 max-w-5xl mx-auto text-center space-y-8">
        <div class="flex items-center justify-center space-x-4" data-aos="fade-down" data-aos-delay="200">
            <span class="h-px w-10 sm:w-16 bg-gradient-to-r from-transparent to-white opacity-30"></span>
            <span class="text-gold text-xs tracking-[5px] uppercase font-medium">The Vault</span>
            <span class="h-px w-10 sm:w-16 bg-gradient-to-l from-transparent to-white opacity-30"></span>
        </div>
        <h1 class="hero-title font-serif font-bold text-white gold-glow" data-aos="zoom-in" data-aos-delay="300">
            Browse <br class="sm:hidden">
            <span class="gold">Collection</span>
        </h1>
        <p class="text-white/40 text-sm sm:text-base max-w-2xl mx-auto font-light leading-relaxed tracking-widest px-2" data-aos="fade-up" data-aos-delay="400">
            Discover exceptional timepieces and audio masterpieces curated for the discerning collector.
        </p>
    </div>
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1 opacity-30" data-aos="fade-up" data-aos-delay="600">
        <span class="text-[8px] uppercase tracking-[0.3em] text-white/40">Scroll</span>
        <div class="w-px h-10 bg-gradient-to-b from-white/40 to-transparent"></div>
    </div>
</section>

{{-- ===== FILTER BAR – Premium Redesign ===== --}}
<section class="pb-8 px-4">
    <div class="max-w-7xl mx-auto">
        <form method="GET" action="{{ route('user.shop') }}" class="flex flex-col md:flex-row gap-4 items-center justify-between">
            {{-- Category Filters --}}
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('user.shop') }}"
                   class="filter-btn {{ !request('category') ? 'active' : '' }}">
                    All
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('user.shop', ['category' => $cat->id, 'search' => request('search'), 'sort' => request('sort')]) }}"
                       class="filter-btn {{ request('category') == $cat->id ? 'active' : '' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            {{-- Search + Sort (advanced) --}}
            <div class="flex items-center gap-3 w-full md:w-auto">
                {{-- Advanced Search Bar --}}
                <div class="relative flex-1 md:w-72 search-wrapper">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-white/30 transition-colors duration-300 search-icon"
                         fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search collection..."
                           class="search-input w-full py-3 pl-12 pr-12 bg-[#13131a] border border-white/10 rounded-full text-sm text-white placeholder-white/20 focus:outline-none focus:border-gold/50 focus:bg-[#1a1a24] transition-all duration-300"
                           id="searchInput"
                           autocomplete="off">
                    <button type="button"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-white/20 hover:text-white/60 transition-colors duration-200 clear-search hidden"
                            id="clearSearch">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Custom Sort Dropdown --}}
                <div class="relative sort-dropdown" id="sortDropdown">
                    <button type="button"
                            class="sort-toggle flex items-center gap-2 py-3 px-5 bg-[#13131a] border border-white/10 rounded-full text-xs text-white uppercase tracking-[0.1em] transition-all duration-300 hover:border-gold/50 hover:bg-[#1a1a24] focus:outline-none focus:border-gold/50"
                            id="sortToggle">
                        <span class="sort-label">{{ ucfirst(str_replace('_', ' ', request('sort', 'latest'))) }}</span>
                        <svg class="w-3 h-3 transition-transform duration-300 sort-arrow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="sort-menu hidden absolute right-0 top-full mt-2 w-48 bg-[#13131a] border border-white/10 rounded-xl shadow-2xl overflow-hidden z-50"
                         id="sortMenu">
                        @php
                            $sortOptions = [
                                'latest' => 'Latest',
                                'price_asc' => 'Price ↑',
                                'price_desc' => 'Price ↓',
                                'name_asc' => 'Name A-Z',
                                'name_desc' => 'Name Z-A',
                            ];
                        @endphp
                        @foreach($sortOptions as $value => $label)
                            <a href="{{ route('user.shop', array_merge(request()->query(), ['sort' => $value])) }}"
                               class="sort-option block px-5 py-3 text-xs text-white/60 hover:text-white hover:bg-white/5 transition-colors duration-150 {{ request('sort', 'latest') == $value ? 'text-gold bg-white/5' : '' }}"
                               data-value="{{ $value }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

{{-- ===== PRODUCT GRID ===== --}}
<section class="pb-24 px-4">
    <div class="max-w-7xl mx-auto">
        @if($products->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach($products as $product)
            <div class="bg-card-dark rounded-2xl overflow-hidden card-shadow group relative" data-aos="fade-up">
                <a href="{{ route('user.product.detail', $product) }}" class="block">
                    <div class="relative">
                        @if($product->stock <= 3 && $product->stock > 0)
                        <span class="absolute top-3 left-3 z-20 px-2.5 py-1 text-[9px] font-bold uppercase tracking-widest bg-gradient-to-r from-amber-500/20 to-amber-600/20 text-amber-400 border border-amber-500/20 rounded-full">75% OFF</span>
                        @else
                        <span class="absolute top-3 left-3 z-20 px-2.5 py-1 text-[9px] font-bold uppercase tracking-widest bg-gradient-to-r from-emerald-500/20 to-emerald-600/20 text-emerald-400 border border-emerald-500/20 rounded-full">NEW ARRIVAL</span>
                        @endif
                        <div class="product-img-wrapper relative aspect-square">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=600&h=600&fit=crop' }}"
                                 alt="{{ $product->name }}" class="w-full h-full object-cover transition-opacity duration-700 group-hover:opacity-0" loading="lazy">
                            @if($product->image_secondary)
                            <img src="{{ asset('storage/' . $product->image_secondary) }}"
                                 alt="{{ $product->name }}" class="w-full h-full object-cover absolute inset-0 transition-opacity duration-700 opacity-0 group-hover:opacity-100" loading="lazy">
                            @endif
                        </div>
                    </div>
                </a>
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <a href="{{ route('user.product.detail', $product) }}">
                            <h3 class="text-sm font-medium tracking-wide text-white group-hover:gold-hover transition-colors">{{ $product->name }}</h3>
                        </a>
                        <p class="text-[11px] text-white/40 tracking-wider mt-0.5 font-light">{{ $product->category->name ?? 'General' }}</p>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="w-3 h-3 rounded-full bg-[#3b2b52] ring-1 ring-white/10"></span>
                            <span class="w-3 h-3 rounded-full bg-[#1a1a1a] ring-1 ring-white/10"></span>
                        </div>
                        <div class="flex items-center gap-1 mt-2">
                            <span class="text-[10px] text-amber-400/80">★★★★★</span>
                            <span class="text-white/40 text-[11px] ml-1">4.85</span>
                        </div>
                    </div>
                    <div class="mt-5 pt-4 border-t border-white/5 flex items-center justify-between">
                        <span class="text-base font-semibold tracking-wider gold">${{ number_format($product->price, 2) }}</span>
                        <a href="{{ route('user.product.detail', $product) }}" class="btn-gold text-xs py-2.5 px-5">View Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-12">{{ $products->links() }}</div>
        @else
        <div class="text-center py-24">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-white/5 border border-white/10 flex items-center justify-center">
                <svg class="w-6 h-6 text-white/40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
            </div>
            <p class="text-white/40 text-sm">No products found</p>
            <p class="text-[0.625rem] uppercase tracking-[0.2em] text-white/40 mt-2">Try adjusting your search or filters</p>
        </div>
        @endif
    </div>
</section>

{{-- ===== SCRIPTS FOR ADVANCED SEARCH & DROPDOWN ===== --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ---------- Advanced Search: Clear Button ----------
        const searchInput = document.getElementById('searchInput');
        const clearBtn = document.getElementById('clearSearch');
        const filterForm = searchInput ? searchInput.closest('form') : null;

        if (searchInput && clearBtn && filterForm) {
            const toggleClear = () => {
                if (searchInput.value.length > 0) {
                    clearBtn.classList.remove('hidden');
                    clearBtn.classList.add('show');
                } else {
                    clearBtn.classList.add('hidden');
                    clearBtn.classList.remove('show');
                }
            };
            toggleClear();

            searchInput.addEventListener('input', toggleClear);

            // Clear search and submit
            clearBtn.addEventListener('click', function(e) {
                e.preventDefault();
                searchInput.value = '';
                toggleClear();
                // Remove search param from URL by setting value and submitting
                filterForm.submit();
            });

            // Submit on Enter key
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    filterForm.submit();
                }
            });
        }

        // ---------- Custom Sort Dropdown ----------
        const sortToggle = document.getElementById('sortToggle');
        const sortMenu = document.getElementById('sortMenu');
        const sortDropdown = document.getElementById('sortDropdown');

        if (sortToggle && sortMenu && sortDropdown) {
            // Toggle dropdown
            sortToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                sortDropdown.classList.toggle('open');
                sortMenu.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!sortDropdown.contains(e.target)) {
                    sortDropdown.classList.remove('open');
                    sortMenu.classList.add('hidden');
                }
            });

            // Update label dynamically from the active option
            const activeOption = sortMenu.querySelector('.sort-option.text-gold');
            if (activeOption) {
                const labelEl = sortToggle.querySelector('.sort-label');
                if (labelEl) {
                    labelEl.textContent = activeOption.textContent.trim();
                }
            }
        }
    });
</script>

@endsection