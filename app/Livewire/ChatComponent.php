<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatComponent extends Component
{
    public $message = '';
    public $admin;

    /**
     * Mount is called when the component is first initialized.
     */
    public function mount() 
    {
        // Find the admin. If no admin exists, this prevents the page from crashing.
        $this->admin = User::where('role', 'admin')->first();
    }

    /**
     * Validation rules for the message input
     */
    protected $rules = [
        'message' => 'required|string|max:1000',
    ];

    /**
     * Handle sending a new message
     */
    public function sendMessage()
    {
        $this->validate();

        // Ensure we have an admin before trying to send
        if (!$this->admin) {
            session()->flash('error', 'Admin contact not found.');
            return;
        }

        Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $this->admin->id,
            'body'        => $this->message,
            'is_read'     => false,
        ]);

        // Reset the input field
        $this->reset('message');
    }

    /**
     * Fetch messages in real-time
     */
    public function render()
    {
        // Only fetch messages between the current user and the admin
        $adminId = $this->admin ? $this->admin->id : 0;
        $currentUserId = Auth::id();

        $messages = Message::where(function($query) use ($adminId, $currentUserId) {
                $query->where('sender_id', $currentUserId)->where('receiver_id', $adminId);
            })
            ->orWhere(function($query) use ($adminId, $currentUserId) {
                $query->where('sender_id', $adminId)->where('receiver_id', $currentUserId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('livewire.chat-component', compact('messages'));
    }
}