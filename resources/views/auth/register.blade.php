@extends('layouts.app')

@section('title', 'Register - Anonify')

@section('content')
<div class="max-w-md mx-auto px-4 py-2">
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <div class="text-center mb-6">
            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <span class="text-xl">🚀</span>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-1">Create Account</h2>
            <p class="text-gray-600 text-sm">Join Anonify and start receiving anonymous messages</p>
        </div>
        
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <input type="text" id="name" name="name" required 
                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror"
                       value="{{ old('name') }}" placeholder="Enter your full name">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" id="username" name="username" required 
                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all @error('username') border-red-500 @enderror"
                       value="{{ old('username') }}" placeholder="your_unique_username">
                <p class="text-gray-500 text-xs mt-1">🔗 Your link: <span class="font-medium">{{ url('/') }}/<span id="usernamePreview">username</span></span></p>
                @error('username')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" id="email" name="email" required 
                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror"
                       value="{{ old('email') }}" placeholder="your@email.com">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" id="password" name="password" required 
                           class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all @error('password') border-red-500 @enderror"
                           placeholder="Password">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required 
                           class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                           placeholder="Confirm">
                </div>
            </div>
            
            <div class="bg-orange-50 border border-orange-200 rounded-lg p-3">
                <div class="flex items-center">
                    <div class="text-orange-500 text-base mr-2">💡</div>
                    <p class="text-orange-700 text-xs">
                        After registration, you'll get your unique link to share with friends!
                    </p>
                </div>
            </div>
            
            <button type="submit" 
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-4 rounded-lg shadow-lg transition-all transform hover:scale-105">
                🎉 Create My Account
            </button>
        </form>
        
        <div class="mt-4 text-center">
            <p class="text-gray-600 text-sm">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-orange-500 hover:text-orange-600 font-semibold hover:underline">Sign in here</a>
            </p>
        </div>
    </div>
</div>

<script>
    // Username preview update
    const usernameInput = document.getElementById('username');
    const usernamePreview = document.getElementById('usernamePreview');
    
    usernameInput.addEventListener('input', function() {
        const value = this.value || 'your_username';
        usernamePreview.textContent = value;
    });
</script>
@endsection