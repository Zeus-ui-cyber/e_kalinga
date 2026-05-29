<?php

namespace App\Http\Controllers;

use App\Models\CommunityMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    /**
     * Show the community space with all messages and online members.
     */
    public function index()
    {
        // Load all community messages, newest last, with sender relationship
        $messages = CommunityMessage::with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark as "seen" — update read_at for messages NOT sent by the current user
        CommunityMessage::where('sender_id', '!=', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        // Online = last_seen_at within the past 5 minutes
        $onlineMembers = User::whereNotNull('last_seen_at')
            ->where('last_seen_at', '>=', now()->subMinutes(5))
            ->orderByDesc('is_facilitator') // facilitators appear first
            ->get();

        $onlineCount = $onlineMembers->count();

        // View is at resources/views/messages/community.blade.php
        return view('messages.community', compact('messages', 'onlineMembers', 'onlineCount'));
    }

    /**
     * Store a new community message.
     */
    public function send(Request $request)
    {
        $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        CommunityMessage::create([
            'sender_id'    => Auth::id(),
            'body'         => $request->input('body'),
            'is_anonymous' => $request->boolean('is_anonymous'),
        ]);

        return redirect()->route('community.index')->with('success', 'Message sent!');
    }
}