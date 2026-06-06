<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP - Valencia Dial</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet"> --}}
    <style>
        body { font-family: 'Inter', sans-serif; }
        .luxury-title { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-[#0b0b0c] flex items-center justify-center min-h-screen p-4 select-none">

    <div class="bg-[#121214] p-10 rounded-none border border-[#242427] shadow-[0_0_50px_rgba(0,0,0,0.8)] w-full max-w-md relative overflow-hidden">
        
        <div class="absolute top-0 left-0 w-full h-2px bg-gradient from-transparent via-[#d4af37] to-transparent"></div>

        <div class="text-center mb-8">
            <h1 class="luxury-title text-2xl uppercase tracking-[0.3em] text-[#d4af37] font-bold mb-1">VALENCIA DIAL</h1>
            <div class="w-12 h-[1px] bg-[#d4af37]/40 mx-auto mb-4"></div>
            <h2 class="text-white text-sm uppercase tracking-widest font-light mb-2">Enter Verification Code</h2>
            <p class="text-stone-400 text-xs font-light tracking-wide">We sent a 6-digit verification security code to your email.</p>
        </div>

        <!-- Success Alert (Resend hone par ya register se aane par dikhega) -->
        @if(session('success'))
            <div class="bg-emerald-950/20 border border-emerald-900/50 text-emerald-400 text-xs py-3 px-4 rounded-none mb-6 text-center tracking-wide uppercase">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Alert -->
        @if(session('error'))
            <div class="bg-red-950/20 border border-red-900/50 text-red-400 text-xs py-3 px-4 rounded-none mb-6 text-center tracking-wide uppercase">
                {{ session('error') }}
            </div>
        @endif

        <!-- Main OTP Verification Form -->
        <form action="{{ url('/verify-otp') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="space-y-3">
                <label class="block text-stone-400 text-[11px] uppercase tracking-[0.2em] font-medium text-center">Security Code</label>
                
                <input type="text" 
                       name="otp" 
                       maxlength="6" 
                       placeholder="000000" 
                       autocomplete="off"
                       class="w-full text-center tracking-[0.4em] text-3xl font-light bg-[#18181b] border border-[#2e2e33] rounded-none px-4 py-4 text-white placeholder-stone-700 focus:outline-none focus:border-[#d4af37] transition duration-300">
                
                @error('otp') 
                    <span class="text-red-400 text-xs block text-center mt-2 tracking-wide font-light">{{ $message }}</span> 
                @enderror
            </div>

            <button type="submit" class="w-full bg-[#d4af37] hover:bg-[#bfa030] text-black font-semibold text-xs uppercase tracking-[0.2em] py-3.5 rounded-none transition duration-300 shadow-md">
                Verify Account
            </button>
        </form>

        <!-- Separate Form for Resend OTP (Luxury link style) -->
        <div class="text-center mt-6 pt-4 border-t border-[#242427]/50">
            <p class="text-stone-400 text-xs font-light mb-2">Didn't receive the code?</p>
            <form action="{{ route('verify.resend') }}" method="POST">
                @csrf
                <button type="submit" class="text-[#d4af37] hover:text-[#bfa030] text-xs uppercase tracking-widest font-semibold bg-transparent border-none cursor-pointer focus:outline-none transition duration-200">
                    Resend New OTP
                </button>
            </form>
        </div>

        <div class="text-center mt-8">
            <p class="text-stone-500 text-[11px] tracking-widest uppercase">Excellence In Time & Technology</p>
        </div>
    </div>

</body>
</html>