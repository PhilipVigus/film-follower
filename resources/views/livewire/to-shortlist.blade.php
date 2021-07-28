<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4">
            @foreach ($films as $film)
                <div class="mt-4 bg-gray-200 h-56 shadow-lg" wire:key="{{ $loop->index }}">
                    <div class="flex">
                        <a href="{{ $film->trailers->first()->link }}" target="_blank">
                            <img class="h-56 flex-grow-0" src="{{ $film->trailers->first()->image }}" />
                        </a>

                        <div class="w-3/5 border-r border-gray-300 flex flex-col justify-between px-2">
                            <div>
                                <h2 class="font-bold text-2xl">{{ $film->title }}</h2>

                                <div class="mt-2 h-max flex-grow">
                                    @forelse ($film->tags as $tag)
                                        <a class="whitespace-nowrap" href="{{ route('tag', ['tag' => $tag]) }}">{{ $tag->name }}</a>@if (! $loop->last),@endif
                                    @empty
                                        <span>
                                            none
                                        </span>
                                    @endforelse
                                </div>
                            </div>

                            <div class="flex divide-gray-300 divide-x border-t border-gray-300 py-2">
                                <button class="w-full" wire:click="$emitTo('modal', 'open', 'priority-details', { film: {{ $film }} })">Shortlist</button>
                                <button class="w-full" wire:click="$emitTo('modal', 'open', 'ignore', { film: {{ $film }} })">Ignore</button>
                            </div>
                        </div>

                        <div class="flex-grow-0 w-80 p-2">
                            <h3 class="font-bold text-lg">Trailers</h2>

                            <div class="mt-2">
                                @foreach ($film->trailers as $trailer)
                                    <a href="{{ $trailer->link }}" target="_blank">
                                        <div class="truncate">{{ $trailer->type }}</div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
