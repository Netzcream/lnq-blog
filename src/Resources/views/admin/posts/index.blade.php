@extends('blog::layouts.dashboard')

@section('dash')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Posts</h1>
        <a href="{{ route('blog.admin.create') }}"
           class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
            + Nuevo
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow-sm rounded-md">
        <table class="w-full text-sm text-left border border-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 font-semibold border-b">Título</th>
                    <th class="px-4 py-2 font-semibold border-b text-center">Categoría</th>
                    <th class="px-4 py-2 font-semibold border-b text-center">Publicado</th>
                    <th class="px-4 py-2 font-semibold border-b text-center">Fecha</th>
                    <th class="px-4 py-2 font-semibold border-b text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border-b">
                            {{ $p->title }}
                        </td>
                        <td class="px-4 py-2 border-b text-center">
                            {{ $p->category?->name ?? '-' }}
                        </td>
                        <td class="px-4 py-2 border-b text-center">
                            @if($p->is_published)
                                <span class="px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Sí</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold text-gray-600 bg-gray-200 rounded-full">No</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 border-b text-center">
                            {{ optional($p->published_at)->format('Y-m-d H:i') ?? '-' }}
                        </td>
                        <td class="px-4 py-2 border-b text-right space-x-2">
                            <a href="{{ route('blog.admin.edit', $p) }}"
                               class="text-blue-600 hover:underline">Editar</a>

                            <form action="{{ route('blog.admin.destroy', $p) }}" method="POST" class="inline"
                                  onsubmit="return confirm('¿Seguro que querés eliminar este post?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                            No hay posts cargados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>
@endsection
