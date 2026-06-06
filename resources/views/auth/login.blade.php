<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Valencia Dial</title>
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
            <div class="w-12 h-1px bg-[#d4af37]/40 mx-auto mb-4"></div>
            <h2 class="text-white text-sm uppercase tracking-widest font-light mb-2">Welcome Back</h2>
            <p class="text-stone-400 text-xs font-light tracking-wide">Sign in to manage your premium collections.</p>
        </div>

        @if(session('success'))
            <div class="bg-emerald-950/20 border border-emerald-900/50 text-emerald-400 text-xs py-3 px-4 rounded-none mb-6 text-center tracking-wide uppercase">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST" class="space-y-5">
            @csrf
            
            <div class="space-y-1">
                <label class="block text-stone-400 text-[11px] uppercase tracking-[0.2em] font-medium">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" autocomplete="off"
                       class="w-full bg-[#18181b] border border-[#2e2e33] rounded-none px-4 py-2.5 text-white placeholder-stone-700 text-sm focus:outline-none focus:border-[#d4af37] transition duration-300">
                @error('email') 
                    <span class="text-red-400 text-xs block mt-1 font-light">{{ $message }}</span> 
                @enderror
            </div>

            <div class="space-y-1">
                <label class="block text-stone-400 text-[11px] uppercase tracking-[0.2em] font-medium">Password</label>
                <input type="password" name="password" 
                       class="w-full bg-[#18181b] border border-[#2e2e33] rounded-none px-4 py-2.5 text-white placeholder-stone-700 text-sm focus:outline-none focus:border-[#d4af37] transition duration-300">
                @error('password') 
                    <span class="text-red-400 text-xs block mt-1 font-light">{{ $message }}</span> 
                @enderror
            </div>

            <div class="flex items-center justify-between text-xs text-stone-400 pt-1">
                <label class="flex items-center space-x-2 cursor-pointer select-none">
                    <input type="checkbox" name="remember" class="accent-[#d4af37] bg-[#18181b] border-[#2e2e33]">
                    <span class="tracking-wide font-light">Remember my session</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-[#d4af37] hover:bg-[#bfa030] text-black font-semibold text-xs uppercase tracking-[0.2em] py-3.5 rounded-none transition duration-300 shadow-md mt-2">
                Sign In
            </button>
        </form>

        <div class="text-center mt-6">
            <p class="text-stone-400 text-xs font-light">
                Don't have an account? <a href="{{ route('register') }}" class="text-[#d4af37] hover:underline tracking-wide ml-1">Register</a>
            </p>
        </div>

        <div class="text-center mt-8">
            <p class="text-stone-500 text-[10px] tracking-widest uppercase">Excellence In Time & Technology</p>
        </div>
    </div>

</body>
</html>