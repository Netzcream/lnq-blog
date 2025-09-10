<?php

namespace Lnq\Blog\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Lnq\Blog\Models\Post;
use Lnq\Blog\Models\Category;

class PostAdminController extends Controller
{
    public function index()
    {
        $posts = Post::with('category')
            ->latest('created_at')
            ->paginate(20);

        return view('blog::admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::ordered()->pluck('name', 'id');
        return view('blog::admin.posts.form', [
            'post' => new Post(),
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $post = Post::create($data);

        return redirect()
            ->route('blog.admin.index')
            ->with('ok', __('Post creado correctamente'));
    }

    public function edit(Post $post)
    {
        $categories = Category::ordered()->pluck('name', 'id');
        return view('blog::admin.posts.form', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $this->validated($request, $post->id);
        $post->update($data);

        return redirect()
            ->route('blog.admin.index')
            ->with('ok', __('Post actualizado correctamente'));
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return back()->with('ok', __('Post eliminado'));
    }

    public function toggle(Post $post)
    {
        $post->update([
            'is_published' => ! $post->is_published,
            'published_at' => $post->is_published ? now() : null,
        ]);

        return back()->with('ok', __('Estado de publicación actualizado'));
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'title'        => ['required', 'array'], // porque es traducible
            'slug'         => [
                'required',
                'string',
                'max:255',
                Rule::unique('blog_posts', 'slug')
                    ->ignore($ignoreId)
                    ->whereNull('deleted_at'),
            ],
            'excerpt'      => ['nullable', 'array'],
            'content'      => ['nullable', 'array'],
            'category_id'  => ['nullable', 'integer', 'exists:blog_categories,id'],
            'is_published' => ['boolean'],
            'published_at' => ['nullable', 'date'],
            'extra_data'   => ['nullable', 'array'],
        ]);
    }
}
