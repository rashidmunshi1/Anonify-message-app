<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Anonify - Anonymous Messages')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Anonify - Send and receive anonymous messages safely and securely. Share your thoughts honestly without revealing your identity.">
    <meta name="keywords" content="anonymous messages, secret messages, anonymous feedback, private messaging">
    <meta property="og:title" content="Anonify - Anonymous Messages">
    <meta property="og:description" content="Send and receive anonymous messages safely and securely">
    <meta property="og:type" content="website">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/favicon.svg">
    <meta name="theme-color" content="#f97316">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slide-up {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes gradient {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .animate-fade-in {
            animation: fade-in 1s ease-out;
        }
        
        .animate-slide-up {
            animation: slide-up 0.8s ease-out;
            animation-fill-mode: both;
        }
        
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient 3s ease infinite;
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        .hover-glow:hover {
            box-shadow: 0 0 30px rgba(251, 146, 60, 0.5);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-2 text-2xl font-bold text-orange-500 hover:text-orange-600 transition-colors">
                        <span class="text-3xl">🕵️</span>
                        <span class="bg-gradient-to-r from-orange-500 to-pink-500 bg-clip-text text-transparent">Anonify</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-orange-500 font-medium transition-colors">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-red-500 font-medium transition-colors">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-orange-500 font-medium transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-6 rounded-lg shadow transition-all">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-6 mx-4 sm:mx-0">
                <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-xl shadow-sm">
                    <div class="flex items-center">
                        <span class="text-xl mr-3">✅</span>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 mx-4 sm:mx-0">
                <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-xl shadow-sm">
                    <div class="flex items-start">
                        <span class="text-xl mr-3 mt-0.5">❌</span>
                        <div>
                            <p class="font-medium mb-2">Please fix the following errors:</p>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="text-sm">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>