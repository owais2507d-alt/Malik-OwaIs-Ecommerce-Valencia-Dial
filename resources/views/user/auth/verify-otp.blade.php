<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP - Valencia Dial</title>
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
                    Securing <br>Your Digital <br><span class="gold">Identity</span>.
                </h2>
                <div class="w-12 h-[1px] gold-bg"></div>
                <p class="text-white/40 text-xs font-light leading-relaxed tracking-wide max-w-xs">
                    Verification is the final gateway to security. Enter the secure signature passkey transmitted to your encrypted mailbox to confirm authenticity.
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
                    <h1 class="font-serif text-2xl md:text-3xl uppercase tracking-[0.25em] font-bold mb-1 text-white/90">VERIFY OTP</h1>
                    <div class="w-10 h-[1px] mx-auto md:mx-0 mb-4 gold-bg"></div>
                    <p class="text-white/40 text-xs font-light tracking-wide">We sent a 6-digit verification security code to your email.</p>
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
                        <label class="block text-white/60 text-[10px] uppercase tracking-[0.25em] font-medium text-center md:text-left">Security Code</label>
                        
                        <input type="text" 
                               name="otp" 
                               maxlength="6" 
                               placeholder="000000" 
                               autocomplete="off"
                               class="smooth-transition w-full text-center tracking-[0.4em] text-3xl font-light rounded-xl px-4 py-4 text-white/90 placeholder-white/20 focus:outline-none focus:ring-0 bg-black/20"
                               style="border: 1px solid rgba(255,255,255,0.1);"
                               onfocus="this.style.borderColor='#d4af37'" onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
                        
                        @error('otp') 
                            <span class="text-red-400 text-xs block text-center md:text-left mt-2 tracking-wide font-light">{{ $message }}</span> 
                        @enderror
                    </div>

                    <button type="submit" class="btn-auth">
                        Verify Account
                    </button>
                </form>

                <div class="text-center md:text-left mt-8 pt-6" style="border-top: 1px solid rgba(255,255,255,0.05);">
                    <p class="text-white/40 text-xs font-light mb-2">Didn't receive the security code?</p>
                    
                    <form action="{{ route('user.verify.resend') }}" method="POST" id="resendForm">
                        @csrf
                        <button type="submit" id="resendBtn" disabled 
                                class="smooth-transition text-xs uppercase tracking-widest font-semibold bg-transparent border-none cursor-not-allowed text-white/40 focus:outline-none">
                            Resend New OTP <span id="timerClock" class="ml-1 text-white/40 font-normal lowercase tracking-normal">(02:00)</span>
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
            
            let totalSeconds = 120;

            const countdownInterval = setInterval(() => {
                let minutes = Math.floor(totalSeconds / 60);
                let seconds = totalSeconds % 60;

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                timerClock.textContent = `(${minutes}:${seconds})`;

                if (totalSeconds <= 0) {
                    clearInterval(countdownInterval);
                    timerClock.textContent = "";
                    resendBtn.removeAttribute("disabled");
                    resendBtn.style.color = "#d4af37";
                    resendBtn.classList.remove("cursor-not-allowed");
                    resendBtn.classList.add("cursor-pointer");
                    
                    resendBtn.onmouseover = function() { this.style.color = "#b8952e"; };
                    resendBtn.onmouseout = function() { this.style.color = "#d4af37"; };
                }

                totalSeconds--;
            }, 1000);
        });
    </script>
</body>
</html>
