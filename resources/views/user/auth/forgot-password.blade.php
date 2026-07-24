<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Valencia Dial</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        .smooth-transition { transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1); }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-0 md:p-8 select-none overflow-x-hidden bg-[#0a0a0f]">

    <div class="w-full max-w-6xl min-h-screen md:min-h-680px grid grid-cols-1 md:grid-cols-12 rounded-none border-0 md:border overflow-hidden" style="border-color: rgba(255,255,255,0.05);">
        
        <div class="animate__animated animate__fadeInLeft hidden md:flex md:col-span-5 p-12 lg:p-16 flex-col justify-between relative border-r bg-[#0a0a0f]" style="border-color: rgba(255,255,255,0.05);">
            
            <div class="absolute inset-6 border pointer-events-none" style="border-color: rgba(255,255,255,0.05);"></div>
            
            <div class="relative z-10">
                <h3 class="font-serif text-xl uppercase tracking-[0.4em] font-bold gold">VALENCIA</h3>
                <p class="text-white/40 text-[9px] tracking-[0.2em] uppercase mt-1">Horology & Innovation</p>
            </div>

            <div class="relative z-10 space-y-5 my-auto">
                <h2 class="font-serif text-3xl lg:text-4xl text-white/90 font-medium leading-tight tracking-wide">
                    Recover <br>Your Bespoke <br><span class="gold">Timeline</span>.
                </h2>
                <div class="w-12 h-[1px] gold-bg"></div>
                <p class="text-white/40 text-xs font-light leading-relaxed tracking-wide max-w-xs">
                    Lost your access token? Provide your registered email address, and our automated vault system will safely dispatch an encrypted reset signature link.
                </p>
            </div>

            <div class="relative z-10">
                <p class="text-white/40 text-[9px] tracking-[0.3em] uppercase">Valencia Dial &copy; 2026</p>
            </div>
        </div>

        <div class="animate__animated animate__fadeInRight col-span-1 md:col-span-7 p-6 sm:p-12 lg:p-16 flex flex-col justify-center bg-[#0a0a0f]">
            
            <div class="absolute top-0 left-0 w-full h-[2px] md:hidden gold-bg opacity-60"></div>

            <div class="w-full max-w-md mx-auto">
                
                <div class="text-center md:text-left mb-8">
                    <h1 class="font-serif text-2xl md:text-3xl uppercase tracking-[0.25em] font-bold mb-1 text-white/90">RESET LINK</h1>
                    <div class="w-10 h-[1px] mx-auto md:mx-0 mb-4 gold-bg"></div>
                    <p class="text-white/40 text-xs font-light tracking-wide">Enter your email to receive recovery instructions.</p>
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
                        <label class="block text-white/60 text-[10px] uppercase tracking-[0.25em] font-medium">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" autocomplete="off" required placeholder="name@domain.com"
                               class="smooth-transition w-full rounded-xl px-4 py-3 text-white/90 placeholder-white/20 text-sm focus:outline-none focus:ring-0 tracking-wide font-light bg-black/20"
                               style="border: 1px solid rgba(255,255,255,0.1);"
                               onfocus="this.style.borderColor='#d4af37'" onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
                        @error('email') 
                            <span class="text-red-400 text-xs block mt-1.5 font-light tracking-wide">{{ $message }}</span> 
                        @enderror
                    </div>

                    <button type="submit" class="btn-auth">
                        Send Reset Link
                    </button>
                </form>

                <div class="w-full h-[1px] my-6" style="background-color: rgba(255,255,255,0.05);"></div>

                <div class="text-center md:text-left">
                    <p class="text-white/40 text-xs font-light tracking-wide">
                        Suddenly remembered? <a href="{{ route('user.login') }}" class="smooth-transition tracking-widest uppercase text-[11px] font-medium ml-1 gold gold-hover">Return To Login</a>
                    </p>
                </div>

            </div>
        </div>

    </div>

</body>
</html>
