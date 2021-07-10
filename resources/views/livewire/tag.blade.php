<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tag - {{ $tag->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4">
            @foreach ($tag->films as $film)
                <div class="mt-4 border" wire:key="{{ $loop->index }}">
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
                        @forelse ($film->tags as $tag)
                            <a href="{{ route('tag', ['tag' => $tag]) }}">{{ $tag->name }}</a>@if (! $loop->last),@endif
                        @empty
                            <span>
                                none
                            </span>
                        @endforelse
                    </div>

                    <div>
                        <button wire:click="$emitTo('modal', 'open', 'priority-details', { film: {{ $film }} })">Shortlist</button>
                    </div>

                    <div>
                        <button wire:click="$emitTo('modal', 'open', 'ignore', { film: {{ $film }} })">Ignore</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>