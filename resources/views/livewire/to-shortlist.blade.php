<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4">
            @foreach ($films as $film)
                <div class="mt-4 bg-gray-200 h-56 shadow-lg relative z-0 overflow-hidden" wire:key="{{ $loop->index }}" x-data="{ ignored: false }">
                    <div class="flex">
                        <a href="{{ $film->trailers->first()->link }}" target="_blank">
                            <img class="h-56 flex-grow-0" src="{{ $film->trailers->first()->image }}" />
                        </a>

                        <div class="w-3/5 border-r border-gray-300 flex flex-col justify-between p-4" :class="{ 'filter blur': ignored }">
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

                            <div class="flex space-x-4">
                                <button class="w-full bg-gray-300 p-2 rounded-md hover:bg-gray-400" x-on:click="ignored = true; $wire.ignoreFilm({{ $film }})">Ignore</button>
                                <button class="w-full bg-blue-800 text-gray-100 p-2 rounded-md hover:bg-blue-900" wire:click="$emitTo('modal', 'open', 'priority-details', { film: {{ $film }} })">Shortlist</button>
                            </div>
                        </div>

                        <div class="flex-grow-0 w-80 p-4" :class="{ 'filter blur': ignored }">
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

                    <div class="absolute inset-0 z-10 bg-white opacity-20 text-black flex items-center justify-center" x-show="ignored" x-cloak>
                    </div>

                    <div class="absolute inset-0 z-10 bg-transparent text-black flex items-center justify-center" x-show="ignored" x-cloak>
                        <div>
                            {{ $film->title }} has been ignored - 
                            <button class="underline" x-on:click="ignored = false; $wire.unignoreFilm({{ $film }})">unignore</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
