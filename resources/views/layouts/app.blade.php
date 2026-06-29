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
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght=0,300;0,400;0,500;1,300&family=Montserrat:wght=100;200;300;400;500;600&display=swap"
        rel="stylesheet">
    <style>
        /* CENTRALIZED PREMIUM COLOR PALETTE (IMAGE LOGO GOLD PROFILE) */
        :root {
            --color-bg-main: #040405;
            --color-dark-gold: #e5c158;
            /* Premium Vibrant Gold from image */
            --color-dark-gold-dim: rgba(229, 193, 88, 0.15);
            --color-gold-bright: #fff2a3;
            /* High-glow highlight profile */
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

        /* CSS Root Helpers */
        .text-dark-gold {
            color: var(--color-dark-gold);
        }

        .bg-dark-gold {
            background-color: var(--color-dark-gold);
        }

        .border-dark-gold {
            border-color: var(--color-dark-gold);
        }

        .border-dark-gold-dim {
            border-color: var(--color-dark-gold-dim);
        }

        .hover-gold-glow:hover {
            color: var(--color-dark-gold);
            text-shadow: 0 0 12px rgba(229, 193, 88, 0.5);
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
</body>

</html>