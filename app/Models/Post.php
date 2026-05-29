<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    /**
     * Table name
     */
    protected $table = 'posts';

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'user_id',
        'title',
        'body',
        'type',
        'event_date',
        'event_location',
        'is_pinned',
    ];

    /**
     * Default values
     */
    protected $attributes = [
        'is_pinned' => false,
    ];

    /**
     * Type casting
     */
    protected $casts = [
        'is_pinned' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Post owner relationship
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Post comments relationship
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)
                    ->latest();
    }

    /**
     * Scope for announcements
     */
    public function scopeAnnouncements($query)
    {
        return $query->where('type', 'announcement');
    }

    /**
     * Scope for events
     */
    public function scopeEvents($query)
    {
        return $query->where('type', 'event');
    }

    /**
     * Scope for updates
     */
    public function scopeUpdates($query)
    {
        return $query->where('type', 'update');
    }

    /**
     * Scope for pinned posts
     */
    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    /**
     * Get post badge color
     */
    public function getBadgeColorAttribute()
    {
        return match ($this->type) {
            'announcement' => 'primary',
            'event' => 'success',
            'update' => 'warning',
            default => 'secondary',
        };
    }

    /**
     * Get post icon
     */
    public function getTypeIconAttribute()
    {
        return match ($this->type) {
            'announcement' => 'speakerphone',
            'event' => 'calendar-event',
            'update' => 'refresh',
            default => 'file-text',
        };
    }

    /**
     * Check if post is event
     */
    public function isEvent(): bool
    {
        return $this->type === 'event';
    }

    /**
     * Check if post is announcement
     */
    public function isAnnouncement(): bool
    {
        return $this->type === 'announcement';
    }

    /**
     * Check if post is update
     */
    public function isUpdate(): bool
    {
        return $this->type === 'update';
    }

    public function reactions(): HasMany
{
    return $this->hasMany(Reaction::class);
}
}