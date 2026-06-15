<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Gateway Authentication - Valencia</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-left-sidebar: #1a233a;  /* Solid Deep Corporate Navy */
            --bg-right-canvas: #f4f7fe;  /* Fox Admin Light Slate Canvas */
            --bg-topbar: #4e84ff;       /* Vibrant Tech Royal Blue Accent */
            --bg-card: #ffffff;         /* Crisp White Surface Card */
            --text-main: #2b3674;       /* Deep Indigo Primary Text */
            --text-secondary: #a3aed0;  /* Soft Dashboard Muted Text */
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .luxury-font { font-family: 'Playfair Display', serif; }
        .smooth-transition { transition: all 0.2s ease-in-out; }
    </style>
</head>
<body class="min-h-screen w-full flex flex-col md:flex-row antialiased overflow-x-hidden bg-[#f4f7fe]">

    <div class="w-full md:w-[40%] xl:w-[35%] p-6 sm:p-10 md:p-12 flex flex-col justify-between items-center md:items-start text-center md:text-left relative shadow-xl z-20" 
         style="background-color: var(--bg-left-sidebar);">
        
        <div class="absolute w-48 h-48 sm:w-72 sm:h-72 rounded-full bg-blue-500/10 blur-[60px] sm:blur-[80px] top-1/3 left-1/4 pointer-events-none"></div>

        <div class="relative z-10 hidden md:block">
            <span class="text-[10px] uppercase tracking-[0.3em] font-bold text-stone-400 opacity-60">Valencia Horology</span>
        </div>

        <div class="my-auto space-y-2 sm:space-y-3 relative z-10 py-6 md:py-0 w-full">
            <h1 class="luxury-font text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold tracking-[0.25em] text-white">VALENCIA</h1>
            <div class="w-12 h-[2px] mx-auto md:mx-0 rounded-full" style="background-color: var(--bg-topbar);"></div>
            <p class="text-stone-300 font-light text-[11px] sm:text-xs tracking-wide max-w-sm mx-auto md:mx-0 leading-relaxed opacity-80 pt-2">
                Executive Control Portal. Deployed exclusively for cataloging, inventory auditing, and global masterpiece asset deployment.
            </p>
        </div>

        <div class="relative z-10 text-[9px] uppercase tracking-widest text-stone-500 font-semibold hidden md:block">
            Secure Infrastructure Security v2.6
        </div>
    </div>

    <div class="flex-1 flex items-center justify-center p-4 sm:p-8 md:p-12 relative z-10" 
         style="background-color: var(--bg-right-canvas);">
        
        <div class="w-full max-w-md space-y-5 sm:space-y-6">
            
            <div class="space-y-1 text-center md:text-left">
                <h2 class="text-xl sm:text-2xl font-bold tracking-tight" style="color: var(--text-main);">Welcome Back, Executive</h2>
                <p class="text-[11px] sm:text-xs font-medium" style="color: var(--text-secondary);">Enter secure clearance keys to establish session connectivity.</p>
            </div>

            @if($errors->any())
                <div class="border text-xs py-3 px-4 rounded-xl bg-red-50 border-red-200 text-red-600 font-medium shadow-sm">
                    @foreach($errors->all() as $error)
                        <div class="flex items-start space-x-1.5">
                            <span class="font-bold">•</span>
                            <span>{{ $error }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="rounded-2xl border border-stone-100 p-5 sm:p-8 shadow-sm bg-white">
                <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4 sm:space-y-5 m-0">
                    @csrf

                    <div class="space-y-1.5">
                        <label for="email" class="block text-[10px] sm:text-[11px] font-bold uppercase tracking-wider text-stone-500">Identity Terminal (Email)</label>
                        <div class="relative">
                            <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="admin@valencia.com" required autofocus
                                   class="w-full text-xs border border-stone-200 rounded-xl pl-4 pr-10 py-3 sm:py-3.5 text-stone-800 placeholder-stone-400 focus:outline-none focus:border-blue-400 focus:bg-stone-50/50 smooth-transition">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-stone-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </span>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label for="password" class="block text-[10px] sm:text-[11px] font-bold uppercase tracking-wider text-stone-500">Clearance Key (Password)</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" placeholder="••••••••••••" required
                                   class="w-full text-xs border border-stone-200 rounded-xl pl-4 pr-10 py-3 sm:py-3.5 text-stone-800 placeholder-stone-400 focus:outline-none focus:border-blue-400 focus:bg-stone-50/50 smooth-transition">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-stone-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center pt-0.5">
                        <label class="flex items-center space-x-2 text-xs font-medium text-stone-500 cursor-pointer select-none">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-stone-200 text-blue-500 focus:ring-0 cursor-pointer accent-blue-500">
                            <span>Keep terminal active</span>
                        </label>
                    </div>

                    <div class="pt-1.5">
                        <button type="submit" class="w-full text-xs font-bold py-3.5 rounded-xl text-white smooth-transition shadow-md cursor-pointer hover:opacity-90 bg-[#4e84ff]">
                            Establish Connection
                        </button>
                    </div>
                </form>
            </div>

            <div class="text-center">
                <a href="{{ route('shop.index') }}" class="text-xs font-semibold hover:underline smooth-transition text-[#4e84ff]">
                    ← Return to Public Showroom Boutique
                </a>
            </div>

        </div>
    </div>

</body>
</html>