<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
        'role', 'student_id', 'program_section',
    ];

    protected $hidden = ['password', 'remember_token'];
    protected $casts  = ['email_verified_at' => 'datetime'];

    public function isAdmin(): bool   { return $this->role === 'admin'; }
    public function isStudent(): bool { return $this->role === 'student'; }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function unreadMessagesCount(): int
    {
        return $this->receivedMessages()->whereNull('read_at')->count();
    }
}