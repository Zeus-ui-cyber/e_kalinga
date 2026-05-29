<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    /**
     * Display feed posts
     */
    public function index()
    {
        $posts = Post::with('user')
            ->latest()
            ->get();

        return view('feed', compact('posts'));
    }

    /**
     * Show single post
     */
    public function show($id)
    {
        $post = Post::with(['user', 'comments.user'])
            ->findOrFail($id);

        return view('feed.show', compact('post'));
    }

    /**
     * Show create page (admin only UI if needed)
     */
    public function create()
    {
        return view('feed.create');
    }

    /**
     * Store new post (MAIN FUNCTION FOR YOUR COMPOSE)
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'           => 'nullable|string|max:120',
            'body'            => 'required|string|max:1000',
            'type'            => 'required|string|in:announcement,event,update',
            'event_date'      => 'nullable|string|max:255',
            'event_location'  => 'nullable|string|max:255',
        ]);

        $post = Post::create([
            'user_id'        => Auth::id(),
            'title'          => $request->title,
            'body'           => $request->body,
            'type'           => $request->type,
            'event_date'     => $request->type === 'event' ? $request->event_date : null,
            'event_location' => $request->type === 'event' ? $request->event_location : null,
        ]);

        // AJAX response support
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'post' => $post
            ]);
        }

        return redirect()->route('feed.index')
            ->with('success', 'Post created successfully!');
    }

    /**
     * Edit post (admin only)
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        return view('feed.edit', compact('post'));
    }

    /**
     * Update post
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'           => 'nullable|string|max:120',
            'body'            => 'required|string|max:1000',
            'type'            => 'required|string|in:announcement,event,update',
            'event_date'      => 'nullable|string|max:255',
            'event_location'  => 'nullable|string|max:255',
        ]);

        $post = Post::findOrFail($id);

        $post->update([
            'title'          => $request->title,
            'body'           => $request->body,
            'type'           => $request->type,
            'event_date'     => $request->type === 'event' ? $request->event_date : null,
            'event_location' => $request->type === 'event' ? $request->event_location : null,
        ]);

        return redirect()->route('feed.index')
            ->with('success', 'Post updated successfully!');
    }

    /**
     * Delete post
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('feed.index')
            ->with('success', 'Post deleted successfully!');
    }
}