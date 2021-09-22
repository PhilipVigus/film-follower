@props(['styling' => 'primary'])

<?php
    switch ($styling) {
        case 'primary':
            $classes = 'w-full bg-blue-800 text-gray-100 p-2 rounded-md hover:bg-blue-900';

            break;
        case 'secondary':
            $classes = 'w-full bg-gray-300 p-2 rounded-md hover:bg-gray-400';

            break;
    }
?>

<button {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
