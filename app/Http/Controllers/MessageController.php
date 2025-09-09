<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;

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
            'content' => 'required|string|max:1000',
        ]);

        Message::create([
            'user_id' => $user->id,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Your anonymous message has been sent!');
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