@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-end px-1 pb-2 border-b-2 font-bold border-black text-lg font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition'
            : 'inline-flex items-end px-1 pb-2 border-b-2 border-transparent text-lg font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
