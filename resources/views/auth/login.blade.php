@extends('layouts.app')

@section('title', 'Login - Anonify')

@section('content')
<div class="max-w-md mx-auto px-4 py-4">
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <div class="text-center mb-6">
            <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <span class="text-xl">🔑</span>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-1">Welcome Back!</h2>
            <p class="text-gray-600 text-sm">Sign in to your Anonify account</p>
        </div>
        
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" id="email" name="email" required 
                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror"
                       value="{{ old('email') }}" placeholder="your@email.com">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password" required 
                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all @error('password') border-red-500 @enderror"
                       placeholder="Enter your password">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <button type="submit" 
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-4 rounded-lg shadow transition-all transform hover:scale-105">
                🚀 Sign In
            </button>
        </form>
        
        <div class="mt-4 text-center">
            <p class="text-gray-600 text-sm">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-orange-500 hover:text-orange-600 font-semibold hover:underline">Create one here</a>
            </p>
        </div>
    </div>
</div>
@endsection