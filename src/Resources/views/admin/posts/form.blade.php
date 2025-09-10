@extends('blog::layouts.dashboard')

@section('dash')
    <h1 class="text-2xl font-semibold mb-6">
        {{ $post->exists ? 'Editar' : 'Crear' }} Post
    </h1>

    <form method="POST"
          action="{{ $post->exists ? route('blog.admin.update', $post) : route('blog.admin.store') }}"
          class="space-y-6">
        @csrf
        @if ($post->exists)
            @method('PUT')
        @endif

        <div class="grid gap-4">
            {{-- título --}}
            <label class="block">
                <span class="block text-sm font-medium text-gray-700">Título</span>
                <input type="text" name="title" value="{{ old('title', $post->title) }}"
                       class="mt-1 block w-full border rounded p-2 @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </label>

            {{-- slug --}}
            <label class="block">
                <span class="block text-sm font-medium text-gray-700">Slug</span>
                <input type="text" name="slug" value="{{ old('slug', $post->slug) }}"
                       class="mt-1 block w-full border rounded p-2 @error('slug') border-red-500 @enderror">
                @error('slug')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </label>

            {{-- categoría --}}
            <label class="block">
                <span class="block text-sm font-medium text-gray-700">Categoría</span>
                <select name="category_id" class="mt-1 block w-full border rounded p-2">
                    <option value="">-- Ninguna --</option>
                    @foreach ($categories as $id => $name)
                        <option value="{{ $id }}" @selected(old('category_id', $post->category_id) == $id)>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </label>

            {{-- excerpt --}}
            <label class="block">
                <span class="block text-sm font-medium text-gray-700">Excerpt</span>
                <textarea name="excerpt" rows="3"
                          class="mt-1 block w-full border rounded p-2 @error('excerpt') border-red-500 @enderror">{{ old('excerpt', $post->excerpt) }}</textarea>
                @error('excerpt')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </label>

            {{-- contenido --}}
            <label class="block">
                <span class="block text-sm font-medium text-gray-700">Contenido</span>
                <x-blog::editor name="content" :value="old('content', $post->content)" />
                @error('content')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </label>

            {{-- publicado / fecha --}}
            <div class="flex items-center gap-6">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="is_published" value="1"
                           @checked(old('is_published', $post->is_published))>
                    <span>Publicado</span>
                </label>
                <label class="block">
                    <span class="block text-sm font-medium text-gray-700">Fecha de publicación</span>
                    <input type="datetime-local" name="published_at"
                           value="{{ old('published_at', optional($post->published_at)->format('Y-m-d\TH:i')) }}"
                           class="mt-1 block border rounded p-2">
                </label>
            </div>

            {{-- botones --}}
            <div>
                <button type="submit"
                        class="px-4 py-2 rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    Guardar
                </button>
                <a href="{{ route('blog.admin.index') }}"
                   class="ml-2 px-4 py-2 rounded-md border border-gray-300 bg-white hover:bg-gray-50">
                    Cancelar
                </a>
            </div>
        </div>
    </form>
@endsection
