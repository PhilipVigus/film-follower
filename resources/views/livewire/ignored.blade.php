<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Films
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ignored films
            </h2>

            @forelse ($ignoredFilms as $film)
                <div class="mt-4 border" wire:key="{{ $loop->index }}">
                    <div class="font-bold text-lg">{{ $film->title }}</div>

                    <div>
                        <button wire:click="$emitTo('modal', 'open', 'unignore', { film: {{ $film }} })">Unignore</button>
                    </div>
                </div>
            @empty
                <div class="mt-4 border">
                    <div class="font-bold text-lg">You are not ignoring any films</div>
                </div>
            @endforelse

            <h2 class="mt-8 font-semibold text-xl text-gray-800 leading-tight">
                Films with ignored tags
            </h2>

            @foreach ($filmsWithIgnoredTags as $film)
                <div class="mt-4 border" wire:key="{{ $loop->index }}">
                    <div class="font-bold text-lg">{{ $film->title }}</div>
                    
                    <div>
                        <p>Ignored tags</p>
                        @foreach ($film->tags as $tag)
                            <a href="{{ route('tag', ['tag' => $tag]) }}">{{ $tag->name }}</a>@if (! $loop->last),@endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
