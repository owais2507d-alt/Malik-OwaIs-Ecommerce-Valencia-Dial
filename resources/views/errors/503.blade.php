<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Under Maintenance — Valencia Dial</title>
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-main: #0c0c0e;
            --text-gold: #d4af37;
            --text-gold-hover: #bfa030;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-main);
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .luxury-title {
            font-family: 'Playfair Display', serif;
        }
        .glow {
            text-shadow: 0 0 40px rgba(212, 175, 55, 0.3);
        }
        .gear {
            animation: spin 8s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .pulse {
            animation: pulse 2s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 0.6; }
            50% { opacity: 1; }
        }
        .fade-in {
            animation: fadeIn 1s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in-d1 { animation-delay: 0.1s; }
        .fade-in-d2 { animation-delay: 0.3s; }
        .fade-in-d3 { animation-delay: 0.5s; }
    </style>
</head>
<body>
    <div class="text-center px-6 max-w-2xl mx-auto fade-in">
        <div class="mb-8 fade-in fade-in-d1">
            <svg class="gear w-24 h-24 mx-auto" style="color: var(--text-gold);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="0.5">
                <circle cx="12" cy="12" r="3" fill="currentColor"/>
                <path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4M4.22 19.78l2.83-2.83M16.95 7.05l2.83-2.83" stroke="currentColor" stroke-width="1.5"/>
            </svg>
        </div>

        <h1 class="luxury-title text-5xl md:text-7xl font-bold text-white glow mb-4 tracking-wide fade-in fade-in-d1">
            <span style="color: var(--text-gold);">503</span>
        </h1>
        <h2 class="luxury-title text-2xl md:text-3xl text-white font-medium mb-6 tracking-wide fade-in fade-in-d2">
            Scheduled <span style="color: var(--text-gold);">Maintenance</span>
        </h2>

        <div class="w-16 h-[1px] mx-auto mb-6 fade-in fade-in-d2" style="background-color: rgba(212, 175, 55, 0.4);"></div>

        <p class="text-stone-400 text-sm md:text-base font-light leading-relaxed max-w-lg mx-auto mb-8 fade-in fade-in-d2">
            {{ $message ?? 'Our atelier is currently undergoing enhancements to serve you with refined precision. The timepiece vault will resume operations shortly.' }}
        </p>

        @if(!empty($endTime))
            <div class="fade-in fade-in-d3 mb-8">
                <span class="text-[#d4af37] text-sm tracking-[0.2em] uppercase font-medium">{{ $endTime }}</span>
            </div>
        @endif

        <div class="inline-flex items-center gap-3 px-6 py-3 border pulse fade-in fade-in-d3" style="border-color: rgba(212, 175, 55, 0.2); color: var(--text-gold);">
            <span class="w-2 h-2 rounded-full" style="background-color: var(--text-gold);"></span>
            <span class="text-xs uppercase tracking-[0.3em] font-medium">Temporarily Unavailable</span>
        </div>

        <div class="mt-12 fade-in fade-in-d3">
            <p class="text-stone-600 text-[10px] tracking-[0.3em] uppercase">Valencia Dial &copy; {{ date('Y') }}</p>
        </div>
    </div>
</body>
</html>
