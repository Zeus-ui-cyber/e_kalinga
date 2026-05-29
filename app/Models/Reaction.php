<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reaction extends Model
{
    use HasFactory;

    /**
     * Table name
     */
    protected $table = 'reactions';

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'user_id',
        'post_id',
        'emoji',
    ];

    /**
     * Type casting
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Available emoji reactions
     */
    public const EMOJIS = [
        '👍',
        '❤️',
        '🎉',
        '👏',
        '🔥',
        '😮',
        '🤔',
        '😂',
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
     * Check if emoji is valid
     */
    public static function isValidEmoji(string $emoji): bool
    {
        return in_array($emoji, self::EMOJIS);
    }

    /**
     * Get reaction count for specific emoji
     */
    public static function getReactionCount($postId, $emoji): int
    {
        return self::where('post_id', $postId)
            ->where('emoji', $emoji)
            ->count();
    }

    /**
     * Check if user already reacted
     */
    public static function userReacted($postId, $userId, $emoji): bool
    {
        return self::where('post_id', $postId)
            ->where('user_id', $userId)
            ->where('emoji', $emoji)
            ->exists();
    }

    /**
     * Toggle reaction
     */
    public static function toggleReaction($postId, $userId, $emoji)
    {
        $reaction = self::where('post_id', $postId)
            ->where('user_id', $userId)
            ->where('emoji', $emoji)
            ->first();

        if ($reaction) {
            $reaction->delete();

            return [
                'reacted' => false,
                'count' => self::getReactionCount($postId, $emoji)
            ];
        }

        self::create([
            'post_id' => $postId,
            'user_id' => $userId,
            'emoji'   => $emoji,
        ]);

        return [
            'reacted' => true,
            'count' => self::getReactionCount($postId, $emoji)
        ];
    }
}