<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Films
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4">
            @foreach ($films as $film)
                <div class="mt-4 border" wire:key="{{ $loop->index }}">
                    <div class="font-bold text-lg">{{ $film->title }}</div>
                    <div>Rating - {{$film->reviews->first()->rating }}</div>
                    <div>{{$film->reviews->first()->comment }}</div>
                </div>

                <div>
                    <button wire:click="$emitTo('modal', 'open', 'remove-review', { film: {{ $film }} })">Remove review</button>
                </div>

                <div>
                    <button wire:click="$emitTo('modal', 'open', 'review-details', { film: {{ $film }} })">Edit review</button>
                </div>
            @endforeach
        </div>
    </div>
</div>
