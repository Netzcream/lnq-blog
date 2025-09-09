@extends('blog::layouts.dashboard')
@section('dash')
    <h1 class="text-xl font-semibold mb-4">{{ $post->exists ? 'Editar' : 'Crear' }} Post</h1>
    <form method="POST" action="{{ $post->exists ? route('blog.admin.update', $post) : route('blog.admin.store') }}">
        @csrf
        @if ($post->exists)
            @method('PUT')
        @endif

        <div class="grid gap-4">
            <label class="block">
                <span>Título</span>
                <input name="title" value="{{ old('title', $post->title) }}" class="w-full border rounded p-2">
            </label>

            <label class="block">
                <span>Slug</span>
                <input name="slug" value="{{ old('slug', $post->slug) }}" class="w-full border rounded p-2">
            </label>

            <label class="block">
                <span>Excerpt</span>
                <textarea name="excerpt" class="w-full border rounded p-2" rows="3">{{ old('excerpt', $post->excerpt) }}</textarea>
            </label>

            <label class="block">
                <span>Contenido</span>

                <x-blog::editor name="content" :value="old('content', $post->content)" />

            </label>

            <label class="inline-flex items-center gap-2">
                <input type="checkbox" name="is_published" value="1"
                    {{ old('is_published', $post->is_published) ? 'checked' : '' }}>
                <span>Publicado</span>
            </label>

            <div>
                <button class="px-4 py-2 border rounded">Guardar</button>
            </div>
        </div>
    </form>
@endsection
