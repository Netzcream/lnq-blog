@extends('blog::layouts.public')
@section('title', $post->title)
@section('content')
    <a href="{{ route('blog.index') }}" class="text-sm underline">← {{ __('blog::ui.back') }}</a>
    <h1 class="text-3xl font-bold mt-2">{{ $post->title }}</h1>
    @if ($post->excerpt)
        <p class="mt-2 opacity-70">{{ $post->excerpt }}</p>
    @endif
    <article class="prose max-w-none mt-6">{!! nl2br(e($post->content)) !!}</article>
@endsection
