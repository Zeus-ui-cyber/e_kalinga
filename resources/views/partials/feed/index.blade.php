@extends('dashboard.layout')

@section('title', 'Org Feed')

@section('content')
    <div class="page-wrap">
        <aside class="sidebar-left"> ... </aside>

        <main class="feed-center">
            <div class="compose-card">
                @include('feed.partials.compose')
            </div>

            <div id="posts-container">
                @foreach($posts as $post)
                    <div class="post-card">
                        <div class="post-header">
                            <div class="post-av">{{ substr($post->user->name, 0, 1) }}</div>
                            <div class="post-meta">
                                <div class="post-author">{{ $post->user->name }}</div>
                                <div class="post-byline">{{ $post->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <div class="post-body">
                            <div class="post-text">{{ $post->body }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </main>

        <aside class="sidebar-right"> ... </aside>
    </div>
@endsection


<script>
    let posts = @json($posts); // Laravel injects the database data directly into JS
    renderPosts();
</script>