<?php

namespace Lnq\Blog\Http\Controllers;

use Illuminate\Routing\Controller;
use Lnq\Blog\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::query()
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->paginate(12);

        return view('blog::public.index', compact('posts'));
    }

    public function show(string $slug)
    {
        $post = Post::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->firstOrFail();

        return view('blog::public.show', compact('post'));
    }
}
