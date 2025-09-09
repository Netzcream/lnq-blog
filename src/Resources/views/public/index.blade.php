@extends('blog::layouts.public')
@section('title', 'Blog')
@section('content')
    <h1 class="text-2xl font-bold mb-4">{{ __('blog::ui.latest_posts') }}</h1>
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($posts as $post)
            <a href="{{ route('blog.show', $post->slug) }}" class="block border rounded p-4 hover:shadow">
                <h2 class="font-semibold">{{ $post->title }}</h2>
                <p class="opacity-75 mt-2 line-clamp-3">{{ $post->excerpt }}</p>
            </a>
        @empty
            <p class="opacity-60">No hay publicaciones aún.</p>
        @endforelse
    </div>
    <div class="mt-6">{{ $posts->links() }}</div>
@endsection
