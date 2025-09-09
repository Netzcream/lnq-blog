@extends('blog::layouts.public') {{-- simple por defecto --}}
@section('content')
    <div class="grid grid-cols-12 gap-6">
        <aside class="col-span-3">
            <nav class="space-y-2">
                <a href="{{ route('blog.admin.index') }}">Posts</a>
                <a href="{{ route('blog.admin.create') }}">Nuevo</a>
            </nav>
        </aside>
        <section class="col-span-9">
            @yield('dash')
        </section>
    </div>
@endsection

@push('head')
    <link rel="stylesheet" href="/vendor/blog/blog.css">
    {{-- Si usás Jodit en esta app: --}}
    @if (config('blog.editor') === 'jodit')
        {{-- La app puede cargar Jodit por CDN o donde quiera: --}}
        {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jodit/es2021/jodit.min.css"> --}}
    @endif
@endpush
@push('scripts')
    {{-- Si usás Jodit, la app carga su JS (CDN o propio) --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/jodit/es2021/jodit.min.js"></script> --}}
    <script src="/vendor/blog/blog.js"></script>
@endpush
