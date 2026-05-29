<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reaction extends Model
{
    use HasFactory;

    protected $table = 'reactions';

    protected $fillable = [
        'user_id',
        'post_id',
        'emoji',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public const EMOJIS = ['🔥', '❤️', '🐔', '✨', '🔥'];

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
    | STATIC HELPERS
    |--------------------------------------------------------------------------
    */

    public static function isValidEmoji(string $emoji): bool
    {
        return in_array($emoji, self::EMOJIS);
    }

    public static function getReactionCount(int $postId, string $emoji): int
    {
        return self::where('post_id', $postId)
            ->where('emoji', $emoji)
            ->count();
    }

    public static function userReacted(int $postId, int $userId, string $emoji): bool
    {
        return self::where('post_id', $postId)
            ->where('user_id', $userId)
            ->where('emoji', $emoji)
            ->exists();
    }

    /*
    |--------------------------------------------------------------------------
    | TOGGLE — returns payload for JS animation
    |--------------------------------------------------------------------------
    */

    public static function toggleReaction(int $postId, int $userId, string $emoji): array
    {
        $reaction = self::where('post_id', $postId)
            ->where('user_id', $userId)
            ->where('emoji', $emoji)
            ->first();

        if ($reaction) {
            $reaction->delete();

            return [
                'reacted'   => false,
                'emoji'     => $emoji,
                'count'     => self::getReactionCount($postId, $emoji),
                'animation' => 'shrink', // JS hook: trigger shrink animation
            ];
        }

        self::create([
            'post_id' => $postId,
            'user_id' => $userId,
            'emoji'   => $emoji,
        ]);

        return [
            'reacted'   => true,
            'emoji'     => $emoji,
            'count'     => self::getReactionCount($postId, $emoji),
            'animation' => 'bounce', // JS hook: trigger bounce animation
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | GROUPED — for rendering all reactions on a post
    |--------------------------------------------------------------------------
    */

    public static function groupedForPost(int $postId, int $userId): array
    {
        return collect(self::EMOJIS)->map(function ($emoji) use ($postId, $userId) {
            return [
                'emoji'     => $emoji,
                'count'     => self::getReactionCount($postId, $emoji),
                'reacted'   => self::userReacted($postId, $userId, $emoji),
                'animation' => 'idle',
            ];
        })->toArray();
    }
}