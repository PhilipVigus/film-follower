@props(['submit'])

<div {{ $attributes->merge(['class' => 'mt-8 bg-gray-200 h-auto shadow-md overflow-hidden rounded-md p-6']) }}>
    <form wire:submit.prevent="{{ $submit }}">
        {{ $form }}

        @if (isset($actions))
        {{ $actions }}
        @endif
    </form>
</div>
