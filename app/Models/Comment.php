<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    /**
     * Table name
     */
    protected $table = 'comments';

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'user_id',
        'post_id',
        'comment',
        'likes_count',
    ];

    /**
     * Default values
     */
    protected $attributes = [
        'likes_count' => 0,
    ];

    /**
     * Type casting
     */
    protected $casts = [
        'likes_count' => 'integer',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    /**
     * User relationship
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Post relationship
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get formatted created time
     */
    public function getTimeAgoAttribute()
    {
        return $this->created_at
            ? $this->created_at->diffForHumans()
            : null;
    }

    /**
     * Short comment preview
     */
    public function getShortCommentAttribute()
    {
        return \Illuminate\Support\Str::limit($this->comment, 50);
    }

    /**
     * Like comment
     */
    public function like()
    {
        $this->increment('likes_count');
    }

    /**
     * Unlike comment
     */
    public function unlike()
    {
        if ($this->likes_count > 0) {
            $this->decrement('likes_count');
        }
    }

    /**
     * Scope latest comments
     */
    public function scopeLatestComments($query)
    {
        return $query->latest();
    }

    /**
     * Scope oldest comments
     */
    public function scopeOldestComments($query)
    {
        return $query->oldest();
    }
}