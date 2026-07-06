<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Valencia Dial | Haute Horology Atelier')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300&family=Montserrat:wght@100;200;300;400;500;600&display=swap"
        rel="stylesheet">
    @stack('styles')
    <style>
        /* ============================
           COLOR PALETTE
           ============================ */
        :root {
            --color-bg-main: #040405;
            --color-dark-gold: #e5c158;
            --color-dark-gold-dim: rgba(229, 193, 88, 0.15);
            --color-gold-bright: #fff2a3;
            --gold: #d4af37;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--color-bg-main);
        }

        .luxury-title {
            font-family: 'Cormorant Garamond', serif;
        }

        .smooth-transition {
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .text-dark-gold { color: var(--color-dark-gold); }
        .bg-dark-gold { background-color: var(--color-dark-gold); }
        .border-dark-gold { border-color: var(--color-dark-gold); }
        .border-dark-gold-dim { border-color: var(--color-dark-gold-dim); }

        /* ============================
           BUTTON SYSTEM
           ============================ */

        /* Primary Gold Button */
        .btn-primary {
            background: var(--gold);
            color: #0a0a0d;
            font-weight: 600;
            letter-spacing: 0.2em;
            font-size: 0.625rem;
            text-transform: uppercase;
            padding: 1rem 2rem;
            border-radius: 999px;
            border: 1px solid var(--gold);
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
        }
        .btn-primary:hover {
            background: #c49e2e;
            border-color: #c49e2e;
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.25);
            color: #0a0a0d;
        }
        .btn-primary:disabled, .btn-primary.disabled {
            opacity: 0.3;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Secondary Outline Button */
        .btn-outline {
            background: transparent;
            color: #a1a1aa;
            border: 1px solid rgba(255,255,255,0.1);
            font-weight: 500;
            letter-spacing: 0.15em;
            font-size: 0.6rem;
            text-transform: uppercase;
            padding: 0.75rem 1.5rem;
            border-radius: 999px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
        }
        .btn-outline:hover {
            border-color: rgba(212, 175, 55, 0.4);
            color: var(--gold);
            transform: translateY(-1px);
        }

        /* Ghost Text Button */
        .btn-ghost {
            background: transparent;
            color: #666;
            border: none;
            font-size: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.3em;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 0.5rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }
        .btn-ghost:hover {
            color: var(--gold);
        }

        /* Danger/Ghost Danger */
        .btn-danger {
            background: transparent;
            color: #666;
            border: none;
            font-size: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.3em;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 0.5rem;
        }
        .btn-danger:hover {
            color: #ef4444;
        }

        /* Quantity Circle Button */
        .qty-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.1);
            background: transparent;
            color: #a1a1aa;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            line-height: 1;
        }
        .qty-btn:hover {
            border-color: var(--gold);
            color: var(--gold);
            background: rgba(212, 175, 55, 0.08);
        }
        .qty-btn:disabled {
            opacity: 0.2;
            cursor: not-allowed;
        }

        /* Filter Pill */
        .filter-btn {
            padding: 0.5rem 1.25rem;
            border-radius: 999px;
            font-size: 0.625rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .filter-btn.active {
            background: var(--gold);
            color: #0a0a0d;
            border: 1px solid var(--gold);
        }
        .filter-btn:not(.active) {
            background: transparent;
            color: #a1a1aa;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .filter-btn:not(.active):hover {
            border-color: rgba(212, 175, 55, 0.3);
            color: var(--gold);
        }

        /* Size Modifiers */
        .btn-sm { padding: 0.6rem 1.25rem; font-size: 0.5rem; }
        .btn-lg { padding: 1.25rem 2.5rem; font-size: 0.7rem; }

        /* Icon Button (circle icon) */
        .btn-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #a1a1aa;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.85rem;
        }
        .btn-icon:hover {
            color: var(--gold);
            border-color: rgba(212, 175, 55, 0.3);
            transform: scale(1.1);
        }

        /* Auth button (gold fill with letter-spacing animation) */
        .btn-auth {
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.25em;
            padding: 1rem 2rem;
            border-radius: 0;
            border: none;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1);
            width: 100%;
            background: var(--gold);
            color: black;
        }
        .btn-auth:hover {
            background: #c49e2e;
            letter-spacing: 0.3em;
        }

        /* Newsletter button (inside footer input) */
        .btn-newsletter {
            position: absolute;
            right: 0.25rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.25em;
            color: #a1a1aa;
            padding: 0.5rem 1rem;
            background: rgba(120,120,120,0.2);
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            transition: all 0.5s ease;
        }
        .btn-newsletter:hover {
            color: var(--gold);
            background: rgba(229, 193, 88, 0.1);
            box-shadow: 0 0 20px rgba(229, 193, 88, 0.1);
        }

        /* Hero CTA overlay animation (fill from left) */
        .btn-hero {
            position: relative;
            overflow: hidden;
            padding: 1rem 2rem;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.3em;
            font-weight: 500;
            min-width: 180px;
            text-align: center;
            transition: all 0.5s ease-out;
            display: inline-block;
            text-decoration: none;
            cursor: pointer;
        }
        .btn-hero span {
            position: relative;
            z-index: 10;
        }
        .btn-hero .fill {
            position: absolute;
            inset: 0;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.5s ease-out;
        }
        .btn-hero:hover .fill {
            transform: scaleX(1);
        }
        .btn-hero-outline {
            border: 1px solid rgba(229, 193, 88, 0.4);
            color: #e5c158;
        }
        .btn-hero-outline:hover {
            color: #0a0a0d;
            border-color: #e5c158;
            box-shadow: 0 0 30px rgba(229, 193, 88, 0.15);
        }
        .btn-hero-outline .fill {
            background: #e5c158;
        }
        .btn-hero-solid {
            background: #e5c158;
            color: #0a0a0d;
            border: 1px solid #e5c158;
        }
        .btn-hero-solid:hover {
            color: #e5c158;
        }
        .btn-hero-solid .fill {
            background: #0a0a0d;
        }
        .btn-hero-solid:hover span {
            color: #e5c158;
        }

        /* Product card add-to-cart button */
        .btn-add-cart {
            background: var(--gold);
            color: #0a0a0d;
            font-size: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 999px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        .btn-add-cart:hover {
            background: white;
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.2);
        }

        /* Disabled button state */
        .btn-disabled {
            background: rgba(255,255,255,0.05);
            color: #666;
            font-size: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 999px;
            border: 1px solid rgba(255,255,255,0.06);
            cursor: not-allowed;
            display: inline-block;
        }
    </style>
</head>

<body class="text-stone-400 antialiased min-h-screen flex flex-col justify-between" x-data="{ mobileMenuOpen: false }">

    @include('user.components.navbar')

   
    <main class="w-full flex-grow bg-[#040405]">
        @yield('content')
    </main>

   @include('user.components.footer')

    
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('scripts')
</body>

</html>