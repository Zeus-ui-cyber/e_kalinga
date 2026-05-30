<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a new comment
     */
    public function store(Request $request, Post $post)
{
    $request->validate([
        'comment' => 'required|string|max:1000',
    ]);

    $comment = Comment::create([
        'user_id' => Auth::id(),
        'post_id' => $post->id,
        'comment' => $request->comment,
    ]);

    // SMART CHECK: If the frontend expects JSON, give it JSON
    if ($request->wantsJson() || $request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Comment added successfully.',
            'comment' => $comment->toAnimationPayload()
        ]);
    }

    // Fallback for standard page-reload form submissions
    return back()->with('success', 'Comment added successfully.');
}

    /**
     * Delete a comment
     */
    public function destroy(Comment $comment)
    {
        // optional: allow only owner or admin
        if (Auth::id() !== $comment->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }
}