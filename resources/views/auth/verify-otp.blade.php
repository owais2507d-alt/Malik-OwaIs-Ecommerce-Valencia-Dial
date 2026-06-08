<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP - Valencia Dial</title>
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

    <div class="w-full max-w-6xl min-h-screen md:min-h-[680px] grid grid-cols-1 md:grid-cols-12 rounded-none border-0 md:border shadow-[0_0_80px_rgba(0,0,0,0.95)] overflow-hidden" 
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
                    Securing <br>Your Digital <br><span style="color: var(--text-gold);">Identity</span>.
                </h2>
                <div class="w-12 h-[1px]" style="background-color: rgba(212, 175, 55, 0.6);"></div>
                <p class="text-stone-400 text-xs font-light leading-relaxed tracking-wide max-w-xs">
                    Verification is the final gateway to security. Enter the secure signature passkey transmitted to your encrypted mailbox to confirm authenticity.
                </p>
            </div>

            <div class="relative z-10">
                <p class="text-stone-600 text-[9px] tracking-[0.3em] uppercase">Valencia Dial &copy; 2026</p>
            </div>
        </div>

        <div class="animate__animated animate__fadeInRight col-span-1 md:col-span-7 p-6 sm:p-12 lg:p-16 flex flex-col justify-center" style="background-color: var(--bg-main);">
            
            <div class="absolute top-0 left-0 w-full h-[2px] md:hidden" style="background: gradient-to-r from-transparent via-[var(--text-gold)] to-transparent"></div>

            <div class="w-full max-w-md mx-auto">
                
                <div class="text-center md:text-left mb-8">
                    <h1 class="luxury-title text-2xl md:text-3xl uppercase tracking-[0.25em] font-bold mb-1" style="color: var(--text-gold);">VERIFY OTP</h1>
                    <div class="w-10 h-[1px] mx-auto md:mx-0 mb-4" style="background-color: rgba(212, 175, 55, 0.4);"></div>
                    <p class="text-stone-400 text-xs font-light tracking-wide">We sent a 6-digit verification security code to your email.</p>
                </div>

                @if(session('success'))
                    <div class="border text-xs py-3 px-4 rounded-none mb-6 text-center tracking-wide uppercase"
                         style="background-color: rgba(16, 185, 129, 0.05); border-color: rgba(16, 185, 129, 0.2); color: #34d399;">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="border text-xs py-3 px-4 rounded-none mb-6 text-center tracking-wide uppercase"
                         style="background-color: rgba(239, 68, 68, 0.05); border-color: rgba(239, 68, 68, 0.2); color: #f87171;">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ url('/verify-otp') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="space-y-3">
                        <label class="block text-stone-400 text-[10px] uppercase tracking-[0.25em] font-medium text-center md:text-left">Security Code</label>
                        
                        <input type="text" 
                               name="otp" 
                               maxlength="6" 
                               placeholder="000000" 
                               autocomplete="off"
                               class="smooth-transition w-full text-center tracking-[0.4em] text-3xl font-light rounded-none px-4 py-4 text-white placeholder-stone-800 focus:outline-none focus:ring-1"
                               style="background-color: var(--bg-input); border: 1px solid var(--border-input);"
                               onfocus="this.style.borderColor= 'var(--text-gold)'" onblur="this.style.borderColor='var(--border-input)'">
                        
                        @error('otp') 
                            <span class="text-red-400 text-xs block text-center md:text-left mt-2 tracking-wide font-light">{{ $message }}</span> 
                        @enderror
                    </div>

                    <button type="submit" class="smooth-transition w-full font-semibold text-xs uppercase tracking-[0.25em] py-4 rounded-none shadow-xl block text-center cursor-pointer"
                            style="background-color: var(--text-gold); color: black;"
                            onmouseover="this.style.backgroundColor='var(--text-gold-hover)'; this.style.letterSpacing='0.3em';" 
                            onmouseout="this.style.backgroundColor='var(--text-gold)'; this.style.letterSpacing='0.25em';">
                        Verify Account
                    </button>
                </form>

                <div class="text-center md:text-left mt-8 pt-6" style="border-top: 1px solid var(--border-color);">
                    <p class="text-stone-500 text-xs font-light mb-2">Didn't receive the security code?</p>
                    
                    <form action="{{ route('verify.resend') }}" method="POST" id="resendForm">
                        @csrf
                        <button type="submit" id="resendBtn" disabled 
                                class="smooth-transition text-xs uppercase tracking-widest font-semibold bg-transparent border-none cursor-not-allowed text-stone-600 focus:outline-none">
                            Resend New OTP <span id="timerClock" class="ml-1 text-stone-500 font-normal lowercase tracking-normal">(02:00)</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const timerClock = document.getElementById("timerClock");
            const resendBtn = document.getElementById("resendBtn");
            
            let totalSeconds = 120; // 2 minutes directly mapped to seconds

            const countdownInterval = setInterval(() => {
                let minutes = Math.floor(totalSeconds / 60);
                let seconds = totalSeconds % 60;

                // Adds leading zero if seconds/minutes are in single unit digits
                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                timerClock.textContent = `(${minutes}:${seconds})`;

                if (totalSeconds <= 0) {
                    clearInterval(countdownInterval);
                    // Update state to active once the countdown hits zero
                    timerClock.textContent = "";
                    resendBtn.removeAttribute("disabled");
                    resendBtn.style.color = "var(--text-gold)";
                    resendBtn.classList.remove("cursor-not-allowed");
                    resendBtn.classList.add("cursor-pointer");
                    
                    // Add luxury hover mechanics directly via JS scripts
                    resendBtn.onmouseover = function() { this.style.color = "var(--text-gold-hover)"; };
                    resendBtn.onmouseout = function() { this.style.color = "var(--text-gold)"; };
                }

                totalSeconds--;
            }, 1000);
        });
    </script>
</body>
</html>