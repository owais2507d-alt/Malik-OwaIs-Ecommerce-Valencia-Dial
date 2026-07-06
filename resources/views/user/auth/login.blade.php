<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Valencia Dial</title>
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
                    Welcome <br>Back To <br><span style="color: var(--text-gold);">The Elite</span>.
                </h2>
                <div class="w-12 h-[1px]" style="background-color: rgba(212, 175, 55, 0.6);"></div>
                <p class="text-stone-400 text-xs font-light leading-relaxed tracking-wide max-w-xs">
                    Sign in to resume control of your bespoke collections, manage active dashboards, and explore our newest signature premium dials.
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
                    <h1 class="luxury-title text-2xl md:text-3xl uppercase tracking-[0.25em] font-bold mb-1" style="color: var(--text-gold);">SIGN IN</h1>
                    <div class="w-10 h-[1px] mx-auto md:mx-0 mb-4" style="background-color: rgba(212, 175, 55, 0.4);"></div>
                    <p class="text-stone-400 text-xs font-light tracking-wide">Enter your credentials to manage your premium account.</p>
                </div>

                @if(session('success'))
                    <div class="border text-xs py-3 px-4 rounded-none mb-6 text-center tracking-wide uppercase"
                         style="background-color: rgba(16, 185, 129, 0.05); border-color: rgba(16, 185, 129, 0.2); color: #34d399;">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ url('/login') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div class="space-y-1.5">
                        <label class="block text-stone-400 text-[10px] uppercase tracking-[0.25em] font-medium">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" autocomplete="off" placeholder="name@domain.com"
                               class="smooth-transition w-full rounded-none px-4 py-3 text-white placeholder-stone-700 text-sm focus:outline-none focus:ring-1 tracking-wide font-light"
                               style="background-color: var(--bg-input); border: 1px solid var(--border-input);"
                               onfocus="this.style.borderColor= 'var(--text-gold)'" onblur="this.style.borderColor='var(--border-input)'">
                        @error('email') 
                            <span class="text-red-400 text-xs block mt-1.5 font-light tracking-wide">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-stone-400 text-[10px] uppercase tracking-[0.25em] font-medium">Password</label>
                        <div class="relative w-full">
                            <input type="password" id="password" name="password" placeholder="••••••••"
                                   class="smooth-transition w-full rounded-none pl-4 pr-12 py-3 text-white placeholder-stone-700 text-sm focus:outline-none focus:ring-1 tracking-wide font-light"
                                   style="background-color: var(--bg-input); border: 1px solid var(--border-input);"
                                   onfocus="this.style.borderColor= 'var(--text-gold)'" onblur="this.style.borderColor='var(--border-input)'">
                            <button type="button" onclick="toggleVisibility('password', 'eyeIcon1')" class="smooth-transition absolute inset-y-0 right-0 pr-4 flex items-center text-stone-500 hover:text-var(--text-gold)">
                                <svg id="eyeIcon1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </button>
                        </div>
                        @error('password') 
                            <span class="text-red-400 text-xs block mt-1.5 font-light tracking-wide">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center space-x-2 cursor-pointer select-none">
                            <input type="checkbox" name="remember" class="accent-[#d4af37] rounded-none bg-[#111113] border-[#222226]">
                            <span class="tracking-wide font-light text-[10px] uppercase text-stone-400">Remember session</span>
                        </label>
                        
                        <a href="{{ route('user.password.request') }}" 
                           class="smooth-transition text-[10px] uppercase tracking-widest font-medium text-stone-400 hover:text-var(--text-gold)">
                            Forgot Password?
                        </a>
                    </div>

                    <button type="submit" class="smooth-transition w-full font-semibold text-xs uppercase tracking-[0.25em] py-4 rounded-none shadow-xl mt-4 block text-center cursor-pointer"
                            style="background-color: var(--text-gold); color: black;"
                            onmouseover="this.style.backgroundColor='var(--text-gold-hover)'; this.style.letterSpacing='0.3em';" 
                            onmouseout="this.style.backgroundColor='var(--text-gold)'; this.style.letterSpacing='0.25em';">
                        Sign In
                    </button>
                </form>

                <div class="w-full h-[1px] my-6" style="background-color: var(--border-color);"></div>

                <div class="text-center md:text-left">
                    <p class="text-stone-400 text-xs font-light tracking-wide">
                        New to our circle? <a href="{{ route('user.register') }}" class="smooth-transition tracking-widest uppercase text-[11px] font-medium ml-1" style="color: var(--text-gold);" onmouseover="this.style.color='var(--text-gold-hover)'" onmouseout="this.style.color='var(--text-gold)'">Create Account</a>
                    </p>
                </div>

            </div>
        </div>

    </div>

    <script>
        function toggleVisibility(inputId, iconId) {
            const inputField = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);
            
            if (inputField.type === "password") {
                inputField.type = "text";
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />`;
            } else {
                inputField.type = "password";
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />`;
            }
        }
    </script>
</body>
</html>