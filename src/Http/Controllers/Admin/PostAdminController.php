<?php

namespace Lnq\Blog\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Lnq\Blog\Models\Post;

class PostAdminController extends Controller
{
    public function index()
    {
        $posts = Post::latest('created_at')->paginate(20);
        return view('blog::admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('blog::admin.posts.form', ['post' => new Post()]);
    }

    public function store(Request $r)
    {
        $data = $this->validated($r);
        Post::create($data);
        return redirect()->route('blog.admin.index')->with('ok', 'Post creado');
    }

    public function edit(Post $post)
    {
        return view('blog::admin.posts.form', compact('post'));
    }

    public function update(Request $r, Post $post)
    {
        $post->update($this->validated($r));
        return redirect()->route('blog.admin.index')->with('ok', 'Post actualizado');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return back()->with('ok', 'Post eliminado');
    }

    public function toggle(Post $post)
    {
        $post->is_published = ! $post->is_published;
        $post->published_at = $post->is_published ? now() : null;
        $post->save();

        return back()->with('ok', 'Estado actualizado');
    }

    private function validated(Request $r): array
    {
        return $r->validate([
            'title'        => ['required','string','max:255'],
            'slug'         => ['required','string','max:255','unique:blog_posts,slug,' . ($r->post->id ?? 'null')],
            'excerpt'      => ['nullable','string'],
            'content'      => ['nullable','string'],
            'is_published' => ['boolean'],
            'published_at' => ['nullable','date'],
            'extra_data'   => ['nullable','array'],
        ]);
    }
}
