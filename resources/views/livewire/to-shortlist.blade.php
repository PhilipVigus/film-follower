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
                    <div>{{ $film->title }}</div>

                    <div class="flex space-x-2">
                        @foreach ($film->trailers as $trailer)
                            <div>
                                <div>{{ $trailer->type }}</div>

                                <a href="{{ $trailer->link }}" target="_blank">
                                    <img class="h-32" src="{{ $trailer->image }}" />
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <div>
                        <button wire:click="shortlist({{ $film }})">Shortlist</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
