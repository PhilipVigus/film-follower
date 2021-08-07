<div>
    <div class="max-w-6xl mx-auto">
        @foreach ($films as $film)
            <div class="mt-8 bg-gray-200 h-auto shadow-md overflow-hidden rounded-md p-6" wire:key="{{ $loop->index }}">

                <h2 class="font-bold text-2xl">{{ $film->title }}</h2>

                <div class="flex space-x-6 mt-4">
                    <div class="w-1/2">
                        <a href="{{ $film->trailers->first()->link }}" target="_blank">
                            <img class="flex-grow-0" src="{{ $film->trailers->first()->image }}" />
                        </a>

                        <div class="mt-4 flex space-x-4">
                            <button class="w-full bg-gray-300 p-2 rounded-md hover:bg-gray-400" wire:click="ignoreFilm({{ $film }})">Ignore</button>
                            <button class="w-full bg-blue-800 text-gray-100 p-2 rounded-md hover:bg-blue-900" wire:click="$emitTo('modal', 'open', 'priority-details', { film: {{ $film }} })">Shortlist</button>
                        </div>
                    </div>

                    <div class="w-1/2">
                        <div>
                            <h3 class="font-bold text-lg">Tags</h3>

                            <div class="mt-2">
                                @forelse ($film->tags as $tag)
                                    <a class="whitespace-nowrap" href="{{ route('tag', ['tag' => $tag]) }}">{{ $tag->name }}</a>@if (! $loop->last),@endif
                                @empty
                                    <span>
                                        none
                                    </span>
                                @endforelse
                            </div>
                        </div>

                        <div class="mt-4">
                            <h3 class="font-bold text-lg">Trailers</h3>

                            <ul class="">
                                @foreach ($film->trailers as $trailer)
                                    <a href="{{ $trailer->link }}" target="_blank">
                                        <li class="truncate">{{ $trailer->type }}</li>
                                    </a>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
