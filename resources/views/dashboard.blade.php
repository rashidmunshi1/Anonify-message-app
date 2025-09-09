@extends('layouts.app')

@section('title', 'Dashboard - Anonify')

@section('content')
<div class="max-w-4xl mx-auto px-4">
    <!-- Welcome Header -->
    <div class="bg-white rounded-2xl shadow-lg p-8 mb-8 border border-gray-100">
        <div class="text-center mb-6">
            <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-3xl">👋</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Welcome back, {{ $user->name }}!</h1>
            <p class="text-gray-600">Manage your anonymous messages and share your link</p>
        </div>
        
        <div class="bg-orange-50 border border-orange-200 rounded-xl p-6">
            <h2 class="text-lg font-semibold text-orange-800 mb-3 flex items-center">
                <span class="text-xl mr-2">🔗</span>
                Your Personal Link
            </h2>
            <div class="bg-white p-4 rounded-xl border border-orange-200 mb-4">
                <code class="text-orange-600 font-medium break-all">{{ url('/' . $user->username) }}</code>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <button onclick="copyLink('{{ url('/' . $user->username) }}')" 
                        class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded-lg transition-all transform hover:scale-105">
                    📋 Copy Link
                </button>
                <button onclick="shareLink('{{ url('/' . $user->username) }}')" 
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg transition-all">
                    📤 Share Link
                </button>
            </div>
        </div>
    </div>

    <!-- Messages Section -->
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                <span class="text-2xl mr-3">💌</span>
                Your Messages
            </h2>
            <div class="bg-orange-100 text-orange-700 px-4 py-2 rounded-full font-semibold">
                {{ $messages->count() }} message{{ $messages->count() !== 1 ? 's' : '' }}
            </div>
        </div>

        @if($messages->isEmpty())
            <div class="text-center py-16">
                <div class="text-6xl mb-6">📪</div>
                <h3 class="text-2xl font-bold text-gray-600 mb-4">No messages yet</h3>
                <p class="text-gray-500 mb-6">Share your link to start receiving anonymous messages!</p>
                <button onclick="copyLink('{{ url('/' . $user->username) }}')" 
                        class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-6 rounded-xl transition-all transform hover:scale-105">
                    📋 Copy Your Link
                </button>
            </div>
        @else
            <div class="space-y-4">
                @foreach($messages as $message)
                    <div class="border rounded-2xl p-6 transition-all {{ $message->read_at ? 'bg-gray-50 border-gray-200' : 'bg-orange-50 border-orange-200 shadow-sm' }}">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-start mb-3">
                                    <div class="text-2xl mr-3 mt-1">
                                        {{ $message->read_at ? '📖' : '✉️' }}
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-gray-800 leading-relaxed">{{ $message->content }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center text-sm text-gray-500 ml-11">
                                    <span>{{ $message->created_at->diffForHumans() }}</span>
                                    @if($message->read_at)
                                        <span class="mx-2">•</span>
                                        <span>Read {{ $message->read_at->diffForHumans() }}</span>
                                    @else
                                        <span class="mx-2">•</span>
                                        <span class="text-orange-600 font-semibold">🆕 New</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-2 ml-4">
                                @unless($message->read_at)
                                    <button onclick="markAsRead({{ $message->id }})" 
                                            class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-2 rounded-lg text-sm font-medium transition-all">
                                        ✓ Mark Read
                                    </button>
                                @endunless
                                <form method="POST" action="{{ route('message.delete', $message) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this message?')"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-sm font-medium transition-all">
                                        🗑️ Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<script>
    function copyLink(link) {
        navigator.clipboard.writeText(link).then(() => {
            showNotification('🎉 Link copied to clipboard!', 'success');
        }).catch(() => {
            showNotification('❌ Failed to copy link', 'error');
        });
    }
    
    function shareLink(link) {
        if (navigator.share) {
            navigator.share({
                title: 'Send me anonymous messages!',
                text: 'Send me an anonymous message using this link:',
                url: link
            });
        } else {
            copyLink(link);
        }
    }

    function markAsRead(messageId) {
        fetch(`/messages/${messageId}/read`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('✅ Message marked as read', 'success');
                setTimeout(() => location.reload(), 1000);
            }
        });
    }
    
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
</script>
@endsection