<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'body',
        'is_anonymous',
        'read_at',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'read_at'      => 'datetime',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}