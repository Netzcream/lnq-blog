@props(['name', 'value' => null, 'id' => Str::uuid()])

@if (config('blog.editor') === 'jodit')
    <textarea id="{{ $id }}" name="{{ $name }}" data-editor="jodit">{{ old($name, $value) }}</textarea>
@elseif(config('blog.editor') === 'custom')
    {{-- hook: la app sobreescribe esta vista y mete su editor --}}
    <textarea id="{{ $id }}" name="{{ $name }}">{{ old($name, $value) }}</textarea>
@else
    {{-- textarea por defecto --}}
    <textarea id="{{ $id }}" name="{{ $name }}" class="w-full border rounded p-2" rows="8">{{ old($name, $value) }}</textarea>
@endif
