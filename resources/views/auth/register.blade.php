<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Valencia Dial</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet"> --}}
    <style>
        body { font-family: 'Inter', sans-serif; }
        .luxury-title { font-family: 'Playfair Display', serif; }
        /* Smooth subtle transition for placeholder typing */
        ::placeholder { tracking: normal; font-weight: 300; }
    </style>
</head>
<body class="bg-[#0b0b0c] flex items-center justify-center min-h-screen p-4 select-none">

    <!-- Luxury Register Card Container -->
    <div class="bg-[#121214] p-10 rounded-none border border-[#242427] shadow-[0_0_60px_rgba(0,0,0,0.85)] w-full max-w-md relative overflow-hidden my-8">
        
        <!-- Top Subtle Gold Accent Line -->
        <div class="absolute top-0 left-0 w-full h-2px bg-gradient from-transparent via-[#d4af37] to-transparent"></div>

        <!-- Brand Name & Header -->
        <div class="text-center mb-8">
            <h1 class="luxury-title text-2xl uppercase tracking-[0.3em] text-[#d4af37] font-bold mb-1">VALENCIA DIAL</h1>
            <div class="w-12 h-1px bg-[#d4af37]/40 mx-auto mb-4"></div>
            <h2 class="text-white text-xs uppercase tracking-[0.2em] font-light mb-2">Create Premium Account</h2>
            <p class="text-stone-400 text-xs font-light tracking-wide">Join us to experience excellence in time & technology.</p>
        </div>

        <!-- Form -->
        <form action="{{ url('/register') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Full Name Field -->
            <div class="space-y-1.5">
                <label class="block text-stone-400 text-[10px] uppercase tracking-[0.25em] font-medium">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" autocomplete="off" placeholder="e.g., Alexander Wright"
                       class="w-full bg-[#161619] border border-[#2e2e33] rounded-none px-4 py-3 text-white placeholder-stone-700 text-sm focus:outline-none focus:border-[#d4af37] focus:ring-1 focus:ring-[#d4af37]/20 transition duration-300 tracking-wide font-light">
                @error('name') 
                    <span class="text-red-400 text-xs block mt-1.5 font-light tracking-wide">{{ $message }}</span> 
                @enderror
            </div>

            <!-- Email Address Field -->
            <div class="space-y-1.5">
                <label class="block text-stone-400 text-[10px] uppercase tracking-[0.25em] font-medium">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" autocomplete="off" placeholder="name@domain.com"
                       class="w-full bg-[#161619] border border-[#2e2e33] rounded-none px-4 py-3 text-white placeholder-stone-700 text-sm focus:outline-none focus:border-[#d4af37] focus:ring-1 focus:ring-[#d4af37]/20 transition duration-300 tracking-wide font-light">
                @error('email') 
                    <span class="text-red-400 text-xs block mt-1.5 font-light tracking-wide">{{ $message }}</span> 
                @enderror
            </div>

            <!-- Password Field -->
            <div class="space-y-1.5">
                <label class="block text-stone-400 text-[10px] uppercase tracking-[0.25em] font-medium">Password</label>
                <input type="password" name="password" placeholder="••••••••"
                       class="w-full bg-[#161619] border border-[#2e2e33] rounded-none px-4 py-3 text-white placeholder-stone-700 text-sm focus:outline-none focus:border-[#d4af37] focus:ring-1 focus:ring-[#d4af37]/20 transition duration-300 tracking-wide font-light">
                @error('password') 
                    <span class="text-red-400 text-xs block mt-1.5 font-light tracking-wide">{{ $message }}</span> 
                @enderror
            </div>

            <!-- Confirm Password Field -->
            <div class="space-y-1.5">
                <label class="block text-stone-400 text-[10px] uppercase tracking-[0.25em] font-medium">Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="••••••••"
                       class="w-full bg-[#161619] border border-[#2e2e33] rounded-none px-4 py-3 text-white placeholder-stone-700 text-sm focus:outline-none focus:border-[#d4af37] focus:ring-1 focus:ring-[#d4af37]/20 transition duration-300 tracking-wide font-light">
            </div>

            <!-- Premium Registration Button -->
            <button type="submit" class="w-full bg-[#d4af37] hover:bg-[#bfa030] text-black font-semibold text-xs uppercase tracking-[0.25em] py-4 rounded-none transition duration-300 shadow-xl mt-6 block content-center">
                Create Account
            </button>
        </form>

        <!-- Divider Line -->
        <div class="w-full h-1px bg-[#242427] my-6"></div>

        <!-- Login Redirect Link -->
        <div class="text-center">
            <p class="text-stone-400 text-xs font-light tracking-wide">
                Already part of the elite? <a href="{{ route('login') }}" class="text-[#d4af37] hover:text-[#bfa030] transition duration-200 tracking-widest uppercase text-[11px] font-medium ml-1">Log In</a>
            </p>
        </div>

        <!-- Pure Luxury Footer Statement -->
        <div class="text-center mt-8 pt-2">
            <p class="text-stone-600 text-[9px] tracking-[0.3em] uppercase">Excellence In Time & Technology</p>
        </div>
    </div>

</body>
</html>