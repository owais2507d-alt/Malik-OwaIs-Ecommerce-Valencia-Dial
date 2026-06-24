<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Gateway - Valencia Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .luxury-font {
            font-family: 'Playfair Display', serif;
        }
        .left-panel {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col lg:flex-row">

    <!-- LEFT BANNER -->
    <div class="left-panel lg:w-5/12 xl:w-2/5 p-8 lg:p-12 flex flex-col justify-between text-white relative overflow-hidden">
        
        <div class="absolute inset-0 bg-[radial-gradient(at_center,#4e84ff20_0%,transparent_70%)]"></div>
        
        <div class="relative z-10">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center">
                    <span class="text-blue-600 text-4xl font-bold">V</span>
                </div>
                <div>
                    <span class="text-3xl font-bold tracking-tighter">VALENCIA</span>
                    <span class="block text-blue-200 text-sm -mt-1">ATELIER</span>
                </div>
            </div>
        </div>

        <div class="relative z-10 my-auto text-center lg:text-left">
            <h1 class="luxury-font text-5xl lg:text-6xl font-bold leading-none tracking-tight mb-6">
                COMMAND<br>CENTER
            </h1>
            <p class="text-blue-100 text-lg max-w-md mx-auto lg:mx-0">
                Secure access for authorized administrators only. 
                Manage exclusive timepieces, inventory & global operations.
            </p>
        </div>

        <div class="relative z-10 text-xs text-blue-200/70 tracking-widest hidden lg:block">
            VALENCIA HOROLOGY • EST 2018
        </div>
    </div>

    <!-- RIGHT SIDE - LOGIN FORM -->
    <div class="flex-1 flex items-center justify-center p-6 lg:p-12 bg-gray-50">
        <div class="w-full max-w-md">
            
            <div class="mb-10 text-center lg:text-left">
                <h2 class="text-2xl font-semibold text-gray-900">Welcome Back</h2>
                <p class="text-gray-600 mt-2">Sign in to access the admin panel</p>
            </div>

  

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                           placeholder="admin@valencia.com" required autofocus
                           class="w-full px-5 py-4 border border-gray-300 rounded-2xl focus:outline-none focus:border-blue-500 focus:ring-1 transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" placeholder="••••••••" required
                           class="w-full px-5 py-4 border border-gray-300 rounded-2xl focus:outline-none focus:border-blue-500 focus:ring-1 transition-all">
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 rounded">
                        <span class="text-gray-600">Remember me</span>
                    </label>
                    
                </div>

                <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-4 rounded-2xl shadow-lg transition-all active:scale-95">
                    Sign In
                </button>
            </form>

            <div class="text-center mt-8">
                <a href="{{ route('user.home') ?? '/' }}" 
                   class="text-gray-500 hover:text-gray-700 text-sm flex items-center justify-center gap-2">
                    ← Back to Public Store
                </a>
            </div>
        </div>
    </div>

</body>
</html>