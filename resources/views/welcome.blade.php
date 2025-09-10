@extends('layouts.app')

@section('title', 'Anonify - Send Anonymous Messages')

@section('content')
<!-- Enhanced Hero Section with Advanced Background -->
<div class="relative min-h-screen overflow-hidden">
    <!-- Multi-layer Animated Background -->
    <div class="absolute inset-0 bg-gradient-to-br from-orange-50 via-pink-50 to-purple-50 animate-moving-gradient"></div>
    <div class="absolute inset-0 bg-pattern-dots opacity-30"></div>
    <div class="absolute inset-0 bg-pattern-waves opacity-20"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent animate-pulse-glow"></div>
    
    <!-- Floating Animated Shapes -->
    <div class="floating-shapes">
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
    </div>
    
    <!-- Enhanced Floating Elements with More Animations -->
    <div class="hidden md:block absolute top-10 left-10 text-4xl opacity-25 animate-wave">💌</div>
    <div class="hidden md:block absolute top-16 right-16 text-3xl opacity-20 animate-sparkle" style="animation-delay: 1s;">🔒</div>
    <div class="hidden md:block absolute top-20 right-32 text-4xl opacity-25 animate-float" style="animation-delay: 0.5s;">📝</div>
    <div class="hidden md:block absolute bottom-32 left-16 text-3xl opacity-20 animate-rotate" style="animation-delay: 2s;">⭐</div>
    <div class="hidden md:block absolute bottom-40 right-20 text-2xl opacity-15 animate-wave" style="animation-delay: 3s;">🎭</div>
    <div class="hidden md:block absolute top-1/3 left-1/4 text-5xl opacity-10 animate-pulse-glow" style="animation-delay: 1.5s;">🌟</div>
    <div class="hidden md:block absolute bottom-1/3 right-1/4 text-4xl opacity-15 animate-float" style="animation-delay: 2.5s;">✨</div>

<div class="relative text-center px-4 py-8">
    <div class="mb-6 animate-fade-in">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4 hover:text-orange-500 transition-colors duration-300 cursor-default">
            <span class="animate-bounce inline-block text-3xl md:text-4xl">🕵️</span> 
            <span class="bg-gradient-to-r from-orange-500 via-pink-500 to-purple-500 bg-clip-text text-transparent animate-gradient">Anonify</span>
        </h1>
        <p class="text-xl md:text-2xl text-gray-700 mb-3 animate-slide-up font-medium">Send and receive anonymous messages</p>
        <p class="text-base text-gray-600 animate-slide-up max-w-xl mx-auto mb-6" style="animation-delay: 0.2s;">
            Share your thoughts honestly and anonymously. Perfect for feedback, confessions, or just saying what's on your mind! 💭
        </p>
        
        <!-- Features Row (compact) -->
        <div class="flex flex-wrap justify-center gap-2 mb-6 animate-slide-up" style="animation-delay: 0.4s;">
            <span class="bg-white/80 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-medium text-gray-700 shadow-sm">
                🔒 100% Anonymous
            </span>
            <span class="bg-white/80 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-medium text-gray-700 shadow-sm">
                ⚡ Instant Delivery
            </span>
            <span class="bg-white/80 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-medium text-gray-700 shadow-sm">
                🆓 Completely Free
            </span>
            <span class="bg-white/80 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-medium text-gray-700 shadow-sm">
                📱 Mobile Friendly
            </span>
        </div>
    </div>
    
    @auth
        <div class="max-w-lg mx-auto bg-glass rounded-2xl shadow-2xl p-6 border border-orange-200/30 transform hover:scale-105 transition-all duration-500 hover:shadow-3xl animate-float hover-glow backdrop-blur-md">
            <div class="text-center mb-4">
                <div class="w-14 h-14 bg-gradient-to-br from-orange-100 to-pink-100 rounded-full flex items-center justify-center mx-auto mb-3 transform hover:rotate-12 transition-transform duration-300 hover:scale-110 animate-pulse-glow">
                    <span class="text-2xl animate-sparkle">🔗</span>
                </div>
                <h2 class="text-xl font-bold bg-gradient-to-r from-orange-600 to-pink-600 bg-clip-text text-transparent mb-2">Your Personal Link</h2>
                <p class="text-gray-600 text-sm">Share this link to receive anonymous messages</p>
            </div>
            
            <div class="bg-gradient-to-r from-orange-50 to-pink-50 p-4 rounded-xl border-2 border-dashed border-orange-300/50 mb-4 animate-pulse-glow">
                <code class="text-sm text-orange-700 font-medium break-all">{{ url('/' . auth()->user()->username) }}</code>
            </div>
            
            <button onclick="copyLink()" class="w-full bg-gradient-to-r from-orange-500 via-pink-500 to-purple-500 hover:from-orange-600 hover:via-pink-600 hover:to-purple-600 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition-all duration-500 transform hover:scale-110 hover:shadow-2xl active:scale-95 relative overflow-hidden group animate-moving-gradient">
                <span class="relative z-10">📋 Copy Link</span>
                <div class="absolute inset-0 bg-gradient-to-r from-pink-400 to-purple-500 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            </button>
        </div>
    @else
        <div class="max-w-md mx-auto">
            <div class="bg-glass rounded-2xl shadow-2xl p-6 border border-orange-200/30 mb-6 transform hover:scale-105 transition-all duration-500 hover:shadow-3xl hover:border-orange-300/50 backdrop-blur-md">
                <div class="text-center mb-5">
                    <div class="w-18 h-18 bg-gradient-to-br from-orange-100 via-pink-100 to-purple-100 rounded-full flex items-center justify-center mx-auto mb-3 transform hover:rotate-12 transition-all duration-300 hover:scale-110 animate-pulse-glow">
                        <span class="text-3xl animate-wave">💬</span>
                    </div>
                    <h2 class="text-xl font-semibold bg-gradient-to-r from-orange-600 to-pink-600 bg-clip-text text-transparent mb-2">Get Started</h2>
                    <p class="text-gray-600 text-sm">Create your account and get your personalized link</p>
                </div>
                
                <a href="{{ route('register') }}" class="w-full inline-block bg-gradient-to-r from-orange-500 via-pink-500 to-purple-500 hover:from-orange-600 hover:via-pink-600 hover:to-purple-600 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition-all duration-500 transform hover:scale-110 hover:shadow-2xl active:scale-95 text-center relative overflow-hidden group animate-moving-gradient">
                    <span class="relative z-10">🚀 Create Account</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-pink-400 via-purple-500 to-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </a>
            </div>
            
            <p class="text-gray-600 text-center bg-glass p-3 rounded-lg backdrop-blur-sm">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-orange-500 hover:text-pink-500 font-medium hover:underline transition-colors duration-300">Sign in here</a>
            </p>
        </div>
    @endauth
</div>

</div>
<!-- End Hero Section -->

<!-- Advertisement Section -->
<div class="bg-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-2">✨ Featured Partners</h3>
            <p class="text-gray-600">Supporting anonymous communication worldwide</p>
        </div>

        <!-- Ads Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Ad 1 - Tech Product -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow cursor-pointer transform hover:scale-105 duration-300">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-2xl">
                        💻
                    </div>
                    <div class="ml-3">
                        <h4 class="font-bold text-gray-800">SecureChat Pro</h4>
                        <p class="text-sm text-gray-500">Sponsored</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm mb-4">
                    End-to-end encrypted messaging for businesses. Keep your conversations private and secure.
                </p>
                <div class="bg-blue-50 text-blue-700 px-3 py-2 rounded-lg text-sm font-medium">
                    🔒 Try Free for 30 days
                </div>
            </div>

            <!-- Ad 2 - VPN Service -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow cursor-pointer transform hover:scale-105 duration-300">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-2xl">
                        🛡️
                    </div>
                    <div class="ml-3">
                        <h4 class="font-bold text-gray-800">AnonVPN</h4>
                        <p class="text-sm text-gray-500">Sponsored</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm mb-4">
                    Browse anonymously with military-grade encryption. Protect your privacy online 24/7.
                </p>
                <div class="bg-green-50 text-green-700 px-3 py-2 rounded-lg text-sm font-medium">
                    🚀 50% OFF First Year
                </div>
            </div>

            <!-- Ad 3 - Mobile App -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow cursor-pointer transform hover:scale-105 duration-300">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center text-2xl">
                        📱
                    </div>
                    <div class="ml-3">
                        <h4 class="font-bold text-gray-800">MindfulMoments</h4>
                        <p class="text-sm text-gray-500">Sponsored</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm mb-4">
                    Daily meditation and mindfulness app. Share your journey anonymously with our community.
                </p>
                <div class="bg-purple-50 text-purple-700 px-3 py-2 rounded-lg text-sm font-medium">
                    💜 Download Free
                </div>
            </div>

            <!-- Ad 4 - Online Course -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow cursor-pointer transform hover:scale-105 duration-300">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center text-2xl">
                        📚
                    </div>
                    <div class="ml-3">
                        <h4 class="font-bold text-gray-800">Privacy Academy</h4>
                        <p class="text-sm text-gray-500">Sponsored</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm mb-4">
                    Learn digital privacy and security. Master the art of staying anonymous online.
                </p>
                <div class="bg-yellow-50 text-yellow-700 px-3 py-2 rounded-lg text-sm font-medium">
                    🎓 Enroll Now - $19
                </div>
            </div>

            <!-- Ad 5 - Crypto Service -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow cursor-pointer transform hover:scale-105 duration-300">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center text-2xl">
                        🪙
                    </div>
                    <div class="ml-3">
                        <h4 class="font-bold text-gray-800">CryptoPrivacy</h4>
                        <p class="text-sm text-gray-500">Sponsored</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm mb-4">
                    Anonymous cryptocurrency transactions. Trade with complete privacy and security.
                </p>
                <div class="bg-orange-50 text-orange-700 px-3 py-2 rounded-lg text-sm font-medium">
                    ₿ Trade Anonymous
                </div>
            </div>

            <!-- Ad 6 - Anonymous Survey Tool -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow cursor-pointer transform hover:scale-105 duration-300">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center text-2xl">
                        📊
                    </div>
                    <div class="ml-3">
                        <h4 class="font-bold text-gray-800">SurveySecrets</h4>
                        <p class="text-sm text-gray-500">Sponsored</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm mb-4">
                    Create anonymous surveys and polls. Get honest feedback from your audience.
                </p>
                <div class="bg-pink-50 text-pink-700 px-3 py-2 rounded-lg text-sm font-medium">
                    📈 Start Free Survey
                </div>
            </div>
        </div>

        <!-- Bottom Ad Banner -->
        <div class="mt-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl p-6 text-white text-center">
            <h3 class="text-xl font-bold mb-2">🚀 Want to advertise here?</h3>
            <p class="mb-4 opacity-90">Reach thousands of users who value privacy and anonymity</p>
            <button class="bg-white text-blue-600 px-6 py-2 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                Contact Us for Ad Rates
            </button>
        </div>
    </div>
</div>
<!-- End Advertisement Section -->

<script>
    function copyLink() {
        const link = "{{ url('/' . (auth()->user()->username ?? '')) }}";
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        
        navigator.clipboard.writeText(link).then(() => {
            // Success animation
            button.innerHTML = '<span class="relative z-10">✅ Copied!</span>';
            button.classList.add('bg-green-500', 'hover:bg-green-600');
            button.classList.remove('bg-orange-500', 'hover:bg-orange-600');
            
            // Confetti effect
            showConfetti();
            
            // Reset after 2 seconds
            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('bg-green-500', 'hover:bg-green-600');
                button.classList.add('bg-orange-500', 'hover:bg-orange-600');
            }, 2000);
            
        }).catch(() => {
            // Error animation
            button.innerHTML = '<span class="relative z-10">❌ Failed</span>';
            button.classList.add('bg-red-500', 'hover:bg-red-600');
            button.classList.remove('bg-orange-500', 'hover:bg-orange-600');
            
            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('bg-red-500', 'hover:bg-red-600');
                button.classList.add('bg-orange-500', 'hover:bg-orange-600');
            }, 2000);
        });
    }
    
    function showConfetti() {
        // Simple confetti effect
        const confettiColors = ['#ff6b6b', '#4ecdc4', '#45b7d1', '#f9ca24', '#f0932b'];
        
        for (let i = 0; i < 50; i++) {
            const confetti = document.createElement('div');
            confetti.style.cssText = `
                position: fixed;
                width: 10px;
                height: 10px;
                background: ${confettiColors[Math.floor(Math.random() * confettiColors.length)]};
                left: ${Math.random() * 100}vw;
                top: -10px;
                border-radius: 50%;
                pointer-events: none;
                z-index: 1000;
                animation: fall 3s linear forwards;
            `;
            
            document.body.appendChild(confetti);
            
            setTimeout(() => confetti.remove(), 3000);
        }
    }
    
    // Add fall animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fall {
            to {
                transform: translateY(100vh) rotate(360deg);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
</script>
@endsection