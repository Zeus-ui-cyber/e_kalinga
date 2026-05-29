<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class ReactionController extends Controller
{
    /**
     * Toggle reaction (emoji) on a post
     */
    public function toggle(Request $request, $postId)
    {
        $request->validate([
            'emoji' => 'required|string|max:10',
        ]);

        $post = Post::findOrFail($postId);

        $userId = Auth::id();
        $emoji  = $request->emoji;

        // check if reaction already exists
        $existing = $post->reactions()
            ->where('user_id', $userId)
            ->where('emoji', $emoji)
            ->first();

        // REMOVE reaction if exists (toggle off)
        if ($existing) {
            $existing->delete();

            return response()->json([
                'success' => true,
                'reacted' => false,
                'message' => 'Reaction removed'
            ]);
        }

        // ADD reaction
        $post->reactions()->create([
            'user_id' => $userId,
            'emoji'    => $emoji,
        ]);

        return response()->json([
            'success' => true,
            'reacted' => true,
            'emoji'   => $emoji,
            'message' => 'Reaction added'
        ]);
    }

    /**
     * Get reaction summary for a post (optional UI use)
     */
    public function index($postId)
    {
        $post = Post::with('reactions.user')->findOrFail($postId);

        return response()->json([
            'success'   => true,
            'reactions' => $post->reactions
        ]);
    }
}