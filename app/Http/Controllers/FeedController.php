<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    /**
     * Feed Page
     */
    public function index()
    {
        $posts = Post::with([
                'user',
                'comments.user',
                'reactions'
            ])
            ->latest()
            ->get();

        return view('feed.index', compact('posts'));
    }

    /**
     * Store New Post
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'nullable|string|max:120',
            'body'             => 'required|string|max:1000',
            'type'             => 'required|in:announcement,event,update',
            'event_date'       => 'nullable|string|max:255',
            'event_location'   => 'nullable|string|max:255',
        ]);

        $post = Post::create([
            'user_id'         => Auth::id(),
            'title'           => $request->title,
            'body'            => $request->body,
            'type'            => $request->type,
            'event_date'      => $request->type === 'event'
                                    ? $request->event_date
                                    : null,
            'event_location'  => $request->type === 'event'
                                    ? $request->event_location
                                    : null,
            'is_pinned'       => false,
        ]);

        $post->load('user');

        /**
         * AJAX RESPONSE
         */
        if ($request->ajax()) {

            return response()->json([
                'success' => true,
                'message' => 'Post created successfully!',
                'post'    => [
                    'id'               => $post->id,
                    'title'            => $post->title,
                    'body'             => $post->body,
                    'type'             => $post->type,
                    'event_date'       => $post->event_date,
                    'event_location'   => $post->event_location,
                    'created_at'       => $post->created_at->diffForHumans(),

                    'user' => [
                        'id'        => $post->user->id,
                        'name'      => $post->user->name,
                        'initials'  => strtoupper(substr($post->user->name, 0, 2)),
                    ]
                ]
            ]);
        }

        return redirect()
            ->route('feed.index')
            ->with('success', 'Post created successfully!');
    }

    /**
     * Show Single Post
     */
    public function show($id)
    {
        $post = Post::with([
                'user',
                'comments.user',
                'reactions.user'
            ])
            ->findOrFail($id);

        return view('feed.show', compact('post'));
    }

    /**
     * Edit Page
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        /**
         * OPTIONAL:
         * restrict editing to owner/admin
         */
        if (
            Auth::id() !== $post->user_id &&
            Auth::user()->role !== 'admin'
        ) {
            abort(403);
        }

        return view('feed.edit', compact('post'));
    }

    /**
     * Update Post
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'            => 'nullable|string|max:120',
            'body'             => 'required|string|max:1000',
            'type'             => 'required|in:announcement,event,update',
            'event_date'       => 'nullable|string|max:255',
            'event_location'   => 'nullable|string|max:255',
        ]);

        $post = Post::findOrFail($id);

        /**
         * SECURITY
         */
        if (
            Auth::id() !== $post->user_id &&
            Auth::user()->role !== 'admin'
        ) {
            abort(403);
        }

        $post->update([
            'title'            => $request->title,
            'body'             => $request->body,
            'type'             => $request->type,
            'event_date'       => $request->type === 'event'
                                    ? $request->event_date
                                    : null,
            'event_location'   => $request->type === 'event'
                                    ? $request->event_location
                                    : null,
        ]);

        /**
         * AJAX
         */
        if ($request->ajax()) {

            return response()->json([
                'success' => true,
                'message' => 'Post updated successfully!',
                'post'    => $post
            ]);
        }

        return redirect()
            ->route('feed.index')
            ->with('success', 'Post updated successfully!');
    }

    /**
     * Delete Post
     */
    public function destroy(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        /**
         * SECURITY
         */
        if (
            Auth::id() !== $post->user_id &&
            Auth::user()->role !== 'admin'
        ) {
            abort(403);
        }

        $post->delete();

        if ($request->ajax()) {

            return response()->json([
                'success' => true,
                'message' => 'Post deleted successfully!'
            ]);
        }

        return redirect()
            ->route('feed.index')
            ->with('success', 'Post deleted successfully!');
    }

    /**
     * Pin / Unpin Post
     */
    public function togglePin($id)
    {
        $post = Post::findOrFail($id);

        /**
         * ADMIN ONLY
         */
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $post->is_pinned = !$post->is_pinned;
        $post->save();

        return response()->json([
            'success' => true,
            'pinned'  => $post->is_pinned
        ]);
    }

    /**
     * React to Post
     */
    public function react(Request $request, $id)
    {
        $request->validate([
            'emoji' => 'required|string|max:10'
        ]);

        $post = Post::findOrFail($id);

        $reaction = $post->reactions()
            ->where('user_id', Auth::id())
            ->where('emoji', $request->emoji)
            ->first();

        /**
         * TOGGLE REACTION
         */
        if ($reaction) {

            $reaction->delete();

            return response()->json([
                'success' => true,
                'reacted' => false
            ]);
        }

        $post->reactions()->create([
            'user_id' => Auth::id(),
            'emoji'   => $request->emoji
        ]);

        return response()->json([
            'success' => true,
            'reacted' => true
        ]);
    }

    /**
     * Add Comment
     */
    public function comment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:500'
        ]);

        $post = Post::findOrFail($id);

        $comment = $post->comments()->create([
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);

        $comment->load('user');

        return response()->json([
            'success' => true,
            'comment' => [
                'id'         => $comment->id,
                'comment'    => $comment->comment,
                'created_at' => $comment->created_at->diffForHumans(),

                'user' => [
                    'name' => $comment->user->name,
                ]
            ]
        ]);
    }
}