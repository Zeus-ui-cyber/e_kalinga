<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Show inbox — list of all conversation threads.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            // Admin sees all students who have messaged or can be messaged
            $threads = User::where('role', 'student')
                ->get()
                ->map(function ($student) use ($user) {
                    $lastMessage = Message::where(function ($q) use ($user, $student) {
                        $q->where('sender_id', $user->id)->where('receiver_id', $student->id);
                    })->orWhere(function ($q) use ($user, $student) {
                        $q->where('sender_id', $student->id)->where('receiver_id', $user->id);
                    })->latest()->first();

                    $unread = Message::where('sender_id', $student->id)
                        ->where('receiver_id', $user->id)
                        ->whereNull('read_at')
                        ->count();

                    return [
                        'student'      => $student,
                        'lastMessage'  => $lastMessage,
                        'unread'       => $unread,
                    ];
                })
                ->sortByDesc(fn($t) => $t['lastMessage']?->created_at)
                ->values();

            return view('messages.index', compact('threads'));
        }

        // Student: only thread is with admin
        $admin = User::where('role', 'admin')->first();

if (!$admin) {
    return view('messages.student', ['messages' => collect(), 'admin' => null]);
}

        $messages = Message::where(function ($q) use ($user, $admin) {
            $q->where('sender_id', $user->id)->where('receiver_id', $admin?->id);
        })->orWhere(function ($q) use ($user, $admin) {
            $q->where('sender_id', $admin?->id)->where('receiver_id', $user->id);
        })->orderBy('created_at')->get();

        // Mark all incoming as read
        Message::where('sender_id', $admin?->id)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('messages.student', compact('messages', 'admin'));
    }

    /**
     * Admin: open a specific thread with a student.
     */
    public function show($studentId)
    {
        $user    = Auth::user();
        $student = User::where('role', 'student')->findOrFail($studentId);

        $messages = Message::where(function ($q) use ($user, $student) {
            $q->where('sender_id', $user->id)->where('receiver_id', $student->id);
        })->orWhere(function ($q) use ($user, $student) {
            $q->where('sender_id', $student->id)->where('receiver_id', $user->id);
        })->orderBy('created_at')->get();

        // Mark incoming as read
        Message::where('sender_id', $student->id)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('messages.show', compact('messages', 'student'));
    }

    /**
     * Send a message.
     */
    public function send(Request $request, $receiverId)
    {
        $request->validate([
            'body'         => ['required', 'string', 'max:2000'],
            'is_anonymous' => ['boolean'],
        ]);

        $user     = Auth::user();
        $receiver = User::findOrFail($receiverId);

        // Students can only message admin
        if ($user->isStudent() && !$receiver->isAdmin()) {
            abort(403);
        }

        Message::create([
            'sender_id'    => $user->id,
            'receiver_id'  => $receiver->id,
            'body'         => $request->body,
            'is_anonymous' => $user->isStudent() && $request->boolean('is_anonymous'),
        ]);

        // Redirect back to the correct thread
        if ($user->isAdmin()) {
            return redirect()->route('messages.show', $receiverId)
                ->with('success', 'Message sent.');
        }

        return redirect()->route('messages.index')
            ->with('success', 'Message sent.');
    }
}