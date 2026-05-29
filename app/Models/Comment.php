<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $fillable = [
        'user_id',
        'post_id',
        'comment',
        'likes_count',
    ];

    protected $attributes = [
        'likes_count' => 0,
    ];

    protected $casts = [
        'likes_count' => 'integer',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    protected $appends = [
        'time_ago',
        'short_comment',
        'initials',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS — used by JS for animations
    |--------------------------------------------------------------------------
    */

    public function getTimeAgoAttribute(): ?string
    {
        return $this->created_at?->diffForHumans();
    }

    public function getShortCommentAttribute(): string
    {
        return \Illuminate\Support\Str::limit($this->comment, 50);
    }

    public function getInitialsAttribute(): string
    {
        return $this->user
            ? strtoupper(substr($this->user->name, 0, 2))
            : '??';
    }

    /*
    |--------------------------------------------------------------------------
    | ACTIONS
    |--------------------------------------------------------------------------
    */

    public function like(): void
    {
        $this->increment('likes_count');
    }

    public function unlike(): void
    {
        if ($this->likes_count > 0) {
            $this->decrement('likes_count');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeLatestComments($query)
    {
        return $query->latest();
    }

    public function scopeOldestComments($query)
    {
        return $query->oldest();
    }

    /*
    |--------------------------------------------------------------------------
    | JSON — full payload for AJAX/animation rendering
    |--------------------------------------------------------------------------
    */

    public function toAnimationPayload(): array
    {
        return [
            'id'          => $this->id,
            'comment'     => $this->comment,
            'likes_count' => $this->likes_count,
            'time_ago'    => $this->time_ago,
            'initials'    => $this->initials,
            'user' => [
                'id'   => $this->user?->id,
                'name' => $this->user?->name,
            ],
        ];
    }
}