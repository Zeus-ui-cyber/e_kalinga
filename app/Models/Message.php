<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'body',
        'is_anonymous',
        'read_at',
    ];

    protected $casts = [
        'read_at'      => 'datetime',
        'is_anonymous' => 'boolean',
    ];

    // ── Relationships ──

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // ── Helpers ──

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    public function markAsRead(): void
    {
        if (!$this->read_at) {
            $this->update(['read_at' => now()]);
        }
    }

    // Display name of sender (respects anonymous)
    public function senderDisplayName(): string
    {
        if ($this->is_anonymous) {
            return 'Anonymous Student';
        }
        return $this->sender->name ?? 'Unknown';
    }
}