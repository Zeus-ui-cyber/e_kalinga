<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'body',
        'type',
        'event_date',
        'event_location'
    ];

    /**
     * Post belongs to a user (admin or student)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Optional: if you later add comments system
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}