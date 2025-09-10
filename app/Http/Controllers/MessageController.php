<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Rules\NoProfanity;
use App\Services\ProfanityFilter;

class MessageController extends Controller
{
    public function showForm($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        return view('messages.form', compact('user'));
    }

    public function store(Request $request, $username)
    {
        $user = User::where('username', $username)->firstOrFail();
        
        $request->validate([
            'content' => [
                'required',
                'string',
                'max:1000',
                'min:1',
                new NoProfanity(),
            ],
        ], [
            'content.required' => '📝 Please enter your message.',
            'content.string' => '📝 Message must be text.',
            'content.max' => '📝 Message cannot exceed 1000 characters.',
            'content.min' => '📝 Message cannot be empty.',
        ]);

        // Additional security check before storing
        $profanityFilter = new ProfanityFilter();
        if ($profanityFilter->containsProfanity($request->content)) {
            return back()->withErrors([
                'content' => '🚫 Your message contains inappropriate content and cannot be sent. Please keep your message respectful and appropriate.'
            ])->withInput();
        }

        // Rate limiting check (prevent spam)
        $recentMessages = Message::where('created_at', '>=', now()->subMinutes(5))
            ->count();
            
        if ($recentMessages >= 10) {
            return back()->withErrors([
                'content' => '⏰ Too many messages sent recently. Please wait a few minutes before sending another message.'
            ])->withInput();
        }

        try {
            Message::create([
                'user_id' => $user->id,
                'content' => trim($request->content),
                'ip_address' => $request->ip(), // Store IP for abuse tracking
                'user_agent' => $request->userAgent(), // Store user agent for abuse tracking
            ]);

            return back()->with('success', '✅ Your anonymous message has been sent successfully!');
        } catch (\Exception $e) {
            return back()->withErrors([
                'content' => '❌ Failed to send message. Please try again later.'
            ])->withInput();
        }
    }

    public function markAsRead(Message $message)
    {
        if ($message->user_id !== auth()->id()) {
            abort(403);
        }

        $message->update(['read_at' => now()]);
        
        return response()->json(['success' => true]);
    }

    public function delete(Message $message)
    {
        if ($message->user_id !== auth()->id()) {
            abort(403);
        }

        $message->delete();
        
        return back()->with('success', 'Message deleted successfully!');
    }
}