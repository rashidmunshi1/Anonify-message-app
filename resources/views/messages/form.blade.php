@extends('layouts.app')

@section('title', 'Send Message to ' . $user->name . ' - Anonify')

@section('content')
<div class="max-w-2xl mx-auto px-4">
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-3xl">💌</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Send Anonymous Message</h1>
            <p class="text-lg text-gray-600">to <span class="font-bold text-orange-500">{{ $user->name }}</span></p>
        </div>

        <form method="POST" action="{{ route('message.store', $user->username) }}" class="space-y-6">
            @csrf
            
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-3">Your Anonymous Message</label>
                <div class="relative">
                    <textarea id="content" name="content" rows="8" required maxlength="1000"
                              class="w-full px-4 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all resize-none @error('content') border-red-500 @enderror"
                              placeholder="Write your honest thoughts here... Remember to be kind and respectful! 💭">{{ old('content') }}</textarea>
                </div>
                
                <div class="flex justify-between items-center mt-2">
                    @error('content')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @else
                        <p class="text-gray-500 text-sm">✨ Be honest, be kind</p>
                    @enderror
                    <p class="text-gray-500 text-sm">
                        <span id="charCount" class="font-medium">0</span><span class="text-gray-400">/1000</span>
                    </p>
                </div>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                <div class="flex items-start">
                    <div class="text-blue-500 text-xl mr-3">🕵️</div>
                    <div>
                        <h3 class="text-blue-800 font-semibold text-sm mb-1">100% Anonymous</h3>
                        <p class="text-blue-700 text-sm">
                            Your identity is completely hidden. The recipient will never know who sent this message.
                        </p>
                    </div>
                </div>
            </div>

            <button type="submit" 
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 px-6 rounded-xl shadow-lg transition-all transform hover:scale-105 text-lg">
                🚀 Send Anonymous Message
            </button>
        </form>

        <div class="text-center mt-8 pt-6 border-t border-gray-100">
            <p class="text-gray-600 mb-3">Want to receive anonymous messages too?</p>
            <a href="{{ route('register') }}" class="inline-flex items-center text-orange-500 hover:text-orange-600 font-semibold hover:underline">
                <span>✨ Create your own link</span>
            </a>
        </div>
    </div>
</div>

<script>
    const textarea = document.getElementById('content');
    const charCount = document.getElementById('charCount');
    
    textarea.addEventListener('input', function() {
        charCount.textContent = textarea.value.length;
    });
    
    // Initialize counter
    charCount.textContent = textarea.value.length;
</script>
@endsection