<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Valencia Dial</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght=500;700&family=Inter:wght=300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        :root {
            --bg-main: #0c0c0e;       /* Solid Pitch Black Canvas */
            --bg-input: #111113;      /* Darker field background */
            --border-color: #1e1e21;  /* Subtle divider line */
            --border-input: #222226;  /* Field input border */
            --text-gold: #d4af37;     /* Pure Valencia Gold */
            --text-gold-hover: #bfa030; /* Darker Gold for hover state */
        }

        body { font-family: 'Inter', sans-serif; background-color: var(--bg-main); }
        .luxury-title { font-family: 'Playfair Display', serif; }
        ::placeholder { tracking: normal; font-weight: 300; }
        
        .smooth-transition {
            transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-0 md:p-8 select-none overflow-x-hidden">

    <div class="w-full max-w-6xl min-h-screen md:min-h-680px grid grid-cols-1 md:grid-cols-12 rounded-none border-0 md:border shadow-[0_0_80px_rgba(0,0,0,0.95)] overflow-hidden" 
         style="background-color: var(--bg-main); border-color: var(--border-color);">
        
        <div class="animate__animated animate__fadeInLeft hidden md:flex md:col-span-5 p-12 lg:p-16 flex-col justify-between relative border-r" 
             style="background-color: var(--bg-main); border-color: var(--border-color);">
            
            <div class="absolute inset-6 border pointer-events-none" style="border-color: rgba(212, 175, 55, 0.05);"></div>
            
            <div class="relative z-10">
                <h3 class="luxury-title text-xl uppercase tracking-[0.4em] font-bold" style="color: var(--text-gold);">VALENCIA</h3>
                <p class="text-stone-600 text-[9px] tracking-[0.2em] uppercase mt-1">Horology & Innovation</p>
            </div>

            <div class="relative z-10 space-y-5 my-auto">
                <h2 class="luxury-title text-3xl lg:text-4xl text-white font-medium leading-tight tracking-wide">
                    Recover <br>Your Bespoke <br><span style="color: var(--text-gold);">Timeline</span>.
                </h2>
                <div class="w-12 h-[1px]" style="background-color: rgba(212, 175, 55, 0.6);"></div>
                <p class="text-stone-400 text-xs font-light leading-relaxed tracking-wide max-w-xs">
                    Lost your access token? Provide your registered email address, and our automated vault system will safely dispatch an encrypted reset signature link.
                </p>
            </div>

            <div class="relative z-10">
                <p class="text-stone-600 text-[9px] tracking-[0.3em] uppercase">Valencia Dial &copy; 2026</p>
            </div>
        </div>

        <div class="animate__animated animate__fadeInRight col-span-1 md:col-span-7 p-6 sm:p-12 lg:p-16 flex flex-col justify-center" style="background-color: var(--bg-main);">
            
            <div class="absolute top-0 left-0 w-full h-[2px] md:hidden" style="background: linear-gradient(to right, transparent, var(--text-gold), transparent)"></div>

            <div class="w-full max-w-md mx-auto">
                
                <div class="text-center md:text-left mb-8">
                    <h1 class="luxury-title text-2xl md:text-3xl uppercase tracking-[0.25em] font-bold mb-1" style="color: var(--text-gold);">RESET LINK</h1>
                    <div class="w-10 h-[1px] mx-auto md:mx-0 mb-4" style="background-color: rgba(212, 175, 55, 0.4);"></div>
                    <p class="text-stone-400 text-xs font-light tracking-wide">Enter your email to receive recovery instructions.</p>
                </div>

                @if (session('status'))
                    <div class="border text-xs py-3 px-4 rounded-none mb-6 text-center tracking-wide uppercase"
                         style="background-color: rgba(16, 185, 129, 0.05); border-color: rgba(16, 185, 129, 0.2); color: #34d399;">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ route('user.password.email') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div class="space-y-1.5">
                        <label class="block text-stone-400 text-[10px] uppercase tracking-[0.25em] font-medium">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" autocomplete="off" required placeholder="name@domain.com"
                               class="smooth-transition w-full rounded-none px-4 py-3 text-white placeholder-stone-700 text-sm focus:outline-none focus:ring-1 tracking-wide font-light"
                               style="background-color: var(--bg-input); border: 1px solid var(--border-input);"
                               onfocus="this.style.borderColor= 'var(--text-gold)'" onblur="this.style.borderColor='var(--border-input)'">
                        @error('email') 
                            <span class="text-red-400 text-xs block mt-1.5 font-light tracking-wide">{{ $message }}</span> 
                        @enderror
                    </div>

                    <button type="submit" class="smooth-transition w-full font-semibold text-xs uppercase tracking-[0.25em] py-4 rounded-none shadow-xl mt-4 block text-center cursor-pointer"
                            style="background-color: var(--text-gold); color: black;"
                            onmouseover="this.style.backgroundColor='var(--text-gold-hover)'; this.style.letterSpacing='0.3em';" 
                            onmouseout="this.style.backgroundColor='var(--text-gold)'; this.style.letterSpacing='0.25em';">
                        Send Reset Link
                    </button>
                </form>

                <div class="w-full h-[1px] my-6" style="background-color: var(--border-color);"></div>

                <div class="text-center md:text-left">
                    <p class="text-stone-400 text-xs font-light tracking-wide">
                        Suddenly remembered? <a href="{{ route('user.login') }}" class="smooth-transition tracking-widest uppercase text-[11px] font-medium ml-1" style="color: var(--text-gold);" onmouseover="this.style.color='var(--text-gold-hover)'" onmouseout="this.style.color='var(--text-gold)'">Return To Login</a>
                    </p>
                </div>

            </div>
        </div>

    </div>

</body>
</html>