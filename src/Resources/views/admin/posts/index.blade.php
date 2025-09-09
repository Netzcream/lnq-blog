@extends('blog::layouts.dashboard')
@section('dash')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">Posts</h1>
        <a href="{{ route('blog.admin.create') }}" class="px-3 py-2 border rounded">Nuevo</a>
    </div>

    <table class="w-full border-collapse">
        <thead>
            <tr>
                <th class="border p-2 text-left">Título</th>
                <th class="border p-2">Publicado</th>
                <th class="border p-2">Fecha</th>
                <th class="border p-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $p)
                <tr>
                    <td class="border p-2">{{ $p->title }}</td>
                    <td class="border p-2 text-center">{{ $p->is_published ? 'Sí' : 'No' }}</td>
                    <td class="border p-2 text-center">{{ optional($p->published_at)->format('Y-m-d H:i') }}</td>
                    <td class="border p-2 space-x-2">
                        <a href="{{ route('blog.admin.edit', $p) }}">Editar</a>
                        <form action="{{ route('blog.admin.destroy', $p) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">{{ $posts->links() }}</div>
@endsection
