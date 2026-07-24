<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'VALENCIA DIAL – Timeless Elegance')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    @stack('styles')
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #0a0a0f;
            color: #f5f0eb;
            scroll-behavior: smooth;
        }

        .font-serif { font-family: 'Playfair Display', serif; }
        .gold { color: #d4af37; }
        .gold-bg { background-color: #d4af37; }
        .gold-border { border-color: #d4af37; }
        .gold-hover:hover { color: #d4af37; }
        .gold-bg-hover:hover { background-color: #d4af37; }
        .border-gold { border-color: #d4af37; }

        .nav-link {
            position: relative;
            font-weight: 400;
            letter-spacing: 0.5px;
            transition: color 0.3s ease;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: #d4af37;
            transition: width 0.3s ease;
        }
        .nav-link:hover::after { width: 100%; }
        .nav-link:hover { color: #d4af37; }

        .hero-title { font-size: clamp(2.8rem, 8vw, 6rem); line-height: 1.05; }
        .section-title { font-size: clamp(2rem, 4vw, 2.8rem); }

        .card-shadow { transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94), box-shadow 0.4s ease; }
        .card-shadow:hover { transform: translateY(-10px); box-shadow: 0 20px 60px rgba(212, 175, 55, 0.15); }

        .product-img-wrapper { overflow: hidden; border-radius: 12px 12px 0 0; }
        .product-img-wrapper img { transition: transform 0.6s ease; }
        .product-img-wrapper:hover img { transform: scale(1.06); }

        .btn-gold {
            background: linear-gradient(135deg, #d4af37, #b8952e);
            color: #0a0a0f;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }
        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(212, 175, 55, 0.35);
            background: linear-gradient(135deg, #e0c04a, #c9a84c);
        }

        .btn-outline-gold {
            background: transparent;
            color: #d4af37;
            border: 1.5px solid #d4af37;
            padding: 12px 36px;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }
        .btn-outline-gold:hover {
            background: #d4af37;
            color: #0a0a0f;
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(212, 175, 55, 0.25);
        }

        .btn-premium {
            background: linear-gradient(135deg, #d4af37, #b8952e);
            color: #0a0a0f;
            font-weight: 600;
            padding: 16px 44px;
            border-radius: 50px;
            letter-spacing: 1px;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            box-shadow: 0 4px 25px rgba(212, 175, 55, 0.3);
            text-transform: uppercase;
            font-size: 0.75rem;
        }
        .btn-premium::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, #e0c04a, #c9a84c);
            opacity: 0;
            transition: opacity 0.4s ease;
        }
        .btn-premium:hover::before { opacity: 1; }
        .btn-premium span, .btn-premium i {
            position: relative;
            z-index: 1;
        }
        .btn-premium:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 45px rgba(212, 175, 55, 0.45);
        }

        .feature-icon {
            width: 56px; height: 56px; border-radius: 50%;
            background: rgba(212, 175, 55, 0.12);
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; color: #d4af37;
            transition: all 0.3s ease;
        }
        .feature-card:hover .feature-icon {
            background: #d4af37; color: #0a0a0f; transform: scale(1.05);
        }

        .bg-card-dark { background: #13131a; border: 1px solid rgba(255,255,255,0.04); }
        .bg-section-alt { background: #0f0f16; }

        .footer-link { transition: color 0.3s ease; }
        .footer-link:hover { color: #d4af37; }

        .lifestyle-card {
            background: linear-gradient(145deg, #13131a, #181820);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 24px; padding: 2.5rem 1.75rem; text-align: center;
            transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94); cursor: default;
            position: relative; overflow: hidden;
        }
        .lifestyle-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0;
            height: 2px; background: linear-gradient(90deg, transparent, rgba(212,175,55,0.3), transparent);
            transform: scaleX(0); transition: transform 0.6s ease;
        }
        .lifestyle-card:hover::before { transform: scaleX(1); }
        .lifestyle-card:hover {
            transform: translateY(-10px); border-color: rgba(212,175,55,0.3);
            box-shadow: 0 30px 80px rgba(212, 175, 55, 0.12);
        }
        .lifestyle-card .icon-wrap {
            width: 72px; height: 72px; border-radius: 50%;
            background: rgba(212, 175, 55, 0.08);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.5rem; font-size: 30px; color: #d4af37;
            transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
        }
        .lifestyle-card .icon-wrap::after {
            content: ''; position: absolute; inset: -4px;
            border-radius: 50%; border: 1px solid rgba(212,175,55,0.1);
            transition: all 0.5s ease;
        }
        .lifestyle-card:hover .icon-wrap {
            background: #d4af37; color: #0a0a0f; transform: scale(1.08);
        }
        .lifestyle-card:hover .icon-wrap::after {
            border-color: rgba(212,175,55,0.3); transform: scale(1.1);
        }
        .lifestyle-card h4 {
            font-size: 1.05rem; font-weight: 600; letter-spacing: 0.02em;
            color: rgba(255,255,255,0.9); margin-bottom: 0.5rem;
        }
        .lifestyle-card p {
            font-size: 0.8rem; color: rgba(255,255,255,0.4);
            line-height: 1.6; margin: 0 auto;
        }

        #mobile-menu {
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            transform-origin: top center;
        }
        #mobile-menu.hidden {
            opacity: 0; transform: scaleY(0.92) translateY(-8px); pointer-events: none;
        }
        #mobile-menu:not(.hidden) {
            opacity: 1; transform: scaleY(1) translateY(0); pointer-events: auto;
        }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #0a0a0f; }
        ::-webkit-scrollbar-thumb { background: #d4af37; border-radius: 10px; }

        .category-card {
            position: relative; overflow: hidden; border-radius: 16px;
            cursor: pointer; transition: transform 0.4s ease;
        }
        .category-card:hover { transform: translateY(-6px); }
        .category-card img { transition: transform 0.6s ease; }
        .category-card:hover img { transform: scale(1.08); }
        .category-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(10,10,15,0.85) 0%, transparent 60%);
            display: flex; flex-direction: column; justify-content: flex-end;
            padding: 24px 20px;
        }

        .deco-line { width: 60px; height: 2px; background: #d4af37; margin: 0 auto 12px; }
        .gold-glow { text-shadow: 0 0 40px rgba(212, 175, 55, 0.15); }

        @media (max-width: 640px) {
            .hero-title { font-size: 2.4rem; }
            .btn-gold { font-size: 0.9rem; }
            .lifestyle-card { padding: 1.5rem 1rem; }
        }

        .smooth-transition { transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1); }

        .btn-primary {
            background: linear-gradient(135deg, #d4af37, #b8952e);
            color: #0a0a0f; font-weight: 600; letter-spacing: 0.2em;
            font-size: 0.625rem; text-transform: uppercase;
            padding: 1rem 2rem; border-radius: 50px;
            border: 1.5px solid #d4af37; cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex; align-items: center; justify-content: center;
            gap: 0.5rem; text-decoration: none;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(212, 175, 55, 0.35);
            background: linear-gradient(135deg, #e0c04a, #c9a84c);
        }
        .btn-primary:disabled, .btn-primary.disabled {
            opacity: 0.3; cursor: not-allowed; transform: none; box-shadow: none;
        }

        .btn-outline {
            background: transparent; color: #d4af37;
            border: 1.5px solid #d4af37; font-weight: 500;
            letter-spacing: 0.15em; font-size: 0.6rem; text-transform: uppercase;
            padding: 0.75rem 1.5rem; border-radius: 50px; cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex; align-items: center; justify-content: center;
            gap: 0.5rem; text-decoration: none;
        }
        .btn-outline:hover { background: #d4af37; color: #0a0a0f; transform: translateY(-2px); }

        .btn-ghost {
            background: transparent; color: rgba(255,255,255,0.4);
            border: none; font-size: 0.5rem; text-transform: uppercase;
            letter-spacing: 0.3em; cursor: pointer; transition: all 0.3s ease;
            padding: 0.5rem; display: inline-flex; align-items: center;
            gap: 0.5rem; text-decoration: none;
        }
        .btn-ghost:hover { color: #d4af37; }

        .btn-danger { background: transparent; color: rgba(255,255,255,0.4); border: none; font-size: 0.5rem; text-transform: uppercase; letter-spacing: 0.3em; cursor: pointer; transition: all 0.3s ease; padding: 0.5rem; }
        .btn-danger:hover { color: #ef4444; }

        .qty-btn { width: 36px; height: 36px; border-radius: 50%; border: 1px solid rgba(255,255,255,0.1); background: transparent; color: rgba(255,255,255,0.4); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; font-size: 1.1rem; line-height: 1; }
        .qty-btn:hover { border-color: #d4af37; color: #d4af37; background: rgba(212,175,55,0.08); }
        .qty-btn:disabled { opacity: 0.2; cursor: not-allowed; }

        .filter-btn { padding: 0.5rem 1.25rem; border-radius: 50px; font-size: 0.625rem; letter-spacing: 0.15em; text-transform: uppercase; font-weight: 500; transition: all 0.3s ease; cursor: pointer; text-decoration: none; display: inline-block; }
        .filter-btn.active { background: linear-gradient(135deg, #d4af37, #b8952e); color: #0a0a0f; border: 1px solid #d4af37; }
        .filter-btn:not(.active) { background: transparent; color: rgba(255,255,255,0.4); border: 1px solid rgba(255,255,255,0.1); }
        .filter-btn:not(.active):hover { border-color: #d4af37; color: #d4af37; }

        .btn-sm { padding: 0.6rem 1.25rem; font-size: 0.5rem; }
        .btn-lg { padding: 1.25rem 2.5rem; font-size: 0.7rem; }

        .btn-icon { width: 36px; height: 36px; border-radius: 50%; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); border: 1px solid rgba(255,255,255,0.08); display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.4); cursor: pointer; transition: all 0.3s ease; font-size: 0.85rem; }
        .btn-icon:hover { color: #d4af37; border-color: #d4af37; transform: scale(1.1); }

        .btn-auth { font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.25em; padding: 1rem 2rem; border-radius: 50px; border: none; cursor: pointer; transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1); width: 100%; background: linear-gradient(135deg, #d4af37, #b8952e); color: #0a0a0f; }
        .btn-auth:hover { transform: translateY(-2px); box-shadow: 0 12px 40px rgba(212, 175, 55, 0.35); letter-spacing: 0.3em; }

        .btn-newsletter { position: absolute; right: 0.25rem; top: 50%; transform: translateY(-50%); font-size: 9px; text-transform: uppercase; letter-spacing: 0.25em; color: rgba(255,255,255,0.4); padding: 0.5rem 1rem; background: rgba(255,255,255,0.08); border-radius: 0.5rem; border: none; cursor: pointer; transition: all 0.5s ease; }
        .btn-newsletter:hover { color: #d4af37; background: rgba(212,175,55,0.1); box-shadow: 0 0 20px rgba(212,175,55,0.1); }

        .btn-hero { position: relative; overflow: hidden; padding: 1rem 2rem; font-size: 10px; text-transform: uppercase; letter-spacing: 0.3em; font-weight: 500; min-width: 180px; text-align: center; transition: all 0.5s ease-out; display: inline-block; text-decoration: none; cursor: pointer; }
        .btn-hero span { position: relative; z-index: 10; }
        .btn-hero .fill { position: absolute; inset: 0; transform: scaleX(0); transform-origin: left; transition: transform 0.5s ease-out; }
        .btn-hero:hover .fill { transform: scaleX(1); }
        .btn-hero-outline { border: 1px solid rgba(212,175,55,0.4); color: #d4af37; }
        .btn-hero-outline:hover { color: #0a0a0f; border-color: #d4af37; box-shadow: 0 0 30px rgba(212,175,55,0.15); }
        .btn-hero-outline .fill { background: #d4af37; }
        .btn-hero-solid { background: linear-gradient(135deg, #d4af37, #b8952e); color: #0a0a0f; border: 1px solid #d4af37; }
        .btn-hero-solid:hover { color: #d4af37; }
        .btn-hero-solid .fill { background: #0a0a0f; }
        .btn-hero-solid:hover span { color: #d4af37; }

        .btn-disabled { background: rgba(255,255,255,0.05); color: rgba(255,255,255,0.4); font-size: 0.5rem; text-transform: uppercase; letter-spacing: 0.2em; font-weight: 600; padding: 0.75rem 1.5rem; border-radius: 50px; border: 1px solid rgba(255,255,255,0.06); cursor: not-allowed; display: inline-block; }

        /* Carousel Styles */
        .carousel-slide {
            opacity: 0;
            transition: opacity 0.8s ease-in-out;
            pointer-events: none;
        }
        .carousel-slide.active {
            opacity: 1;
            pointer-events: auto;
        }
        .carousel-slide.active .carousel-title {
            animation: slideUp 0.8s ease-out forwards;
        }
        .carousel-slide.active .carousel-subtitle {
            animation: slideUp 0.6s ease-out 0.1s forwards;
            opacity: 0;
        }
        .carousel-slide.active .carousel-desc {
            animation: slideUp 0.8s ease-out 0.2s forwards;
            opacity: 0;
        }
        .carousel-slide.active .carousel-cta {
            animation: slideUp 0.8s ease-out 0.3s forwards;
            opacity: 0;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .carousel-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 20;
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
        }
        .carousel-nav:hover {
            background: rgba(212,175,55,0.15);
            border-color: #d4af37;
            color: #d4af37;
            transform: translateY(-50%) scale(1.05);
        }
        .carousel-prev { left: 24px; }
        .carousel-next { right: 24px; }
        .carousel-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            border: none;
            cursor: pointer;
            transition: all 0.4s ease;
            padding: 0;
        }
        .carousel-dot.active {
            background: #d4af37;
            width: 28px;
            border-radius: 5px;
        }
        .carousel-dot:hover {
            background: rgba(212,175,55,0.6);
        }
        @media (max-width: 768px) {
            .carousel-nav { width: 40px; height: 40px; font-size: 0.8rem; }
            .carousel-prev { left: 12px; }
            .carousel-next { right: 12px; }
            .carousel-slide .carousel-content h1 { font-size: 2.5rem; }
        }
    </style>
</head>

<body class="antialiased min-h-screen flex flex-col justify-between" x-data="{ mobileMenuOpen: false }">

    @include('user.components.navbar')

    <main class="w-full flex-grow">
        @yield('content')
    </main>

    @include('user.components.footer')

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 600, offset: 80, once: true, easing: 'ease-out-cubic' });
    </script>
    @stack('scripts')
</body>
</html>
