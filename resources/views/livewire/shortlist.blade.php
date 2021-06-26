<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Films
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4">
            @foreach ($films as $film)
                <div class="mt-4 border">
                    <div class="font-bold text-lg">{{ $film->title }}</div>
                    <div>Priority - {{$film->priorities->first()->priority }}</div>
                    <div>{{$film->priorities->first()->comment }}</div>

                    <div>
                        <button wire:click="unshortlist({{ $film }})">Unshortlist</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
