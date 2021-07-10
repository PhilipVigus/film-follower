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
                    <div>Level - {{$film->priorities->first()->level }}</div>
                    <div>{{$film->priorities->first()->comment }}</div>

                    <div>
                        <button wire:click="$emitTo('modal', 'open', 'review-details', { film: {{ $film }} })">Review film</button>
                    </div>

                    <div>
                        <button wire:click="$emitTo('modal', 'open', 'priority-details', { film: {{ $film }} })">Edit details</button>
                    </div>

                    <div>
                        <button wire:click="$emitTo('modal', 'open', 'remove-from-shortlist', { film: {{ $film }} })">Remove from shortlist</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
