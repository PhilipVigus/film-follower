<div class="max-w-6xl mx-auto">
    <div class="mt-8 bg-gray-200 h-auto shadow-md rounded-md p-6">
        <h2 class="font-bold text-2xl">Films tagged with '{{ $tag->name }}'</h2>
    </div>

    <div class="mt-8 bg-gray-200 h-auto shadow-md rounded-md p-6">
        <h3 class="font-bold text-xl">To shortlist</h2>

        <div class="flex flex-wrap">
            @forelse ($filmsToShortlist as $film)
                <div class="mt-4 border w-1/3" wire:key="{{ $loop->index }}">
                    <a href="{{ route('film', ['film' => $film]) }}">
                        <h4 class="font-bold pl-4 truncate">{{ $film->title }}</h4>

                        <img class="object-contain p-4" src="{{ $film->trailers->first()->image }}" />
                    </a>
                </div>
            @empty
                <div class="mt-4 border"">
                    None
                </div>
            @endforelse
        </div>
    </div>

    <div class="mt-8 bg-gray-200 h-auto shadow-md rounded-md p-6">
        <h3 class="font-bold text-xl">Shortlisted</h2>

        <div class="flex flex-wrap">
            @forelse ($shortlistedFilms as $film)
                <div class="mt-4 border w-1/3" wire:key="{{ $loop->index }}">
                    <h4 class="font-bold pl-4 truncate">{{ $film->title }}</h4>

                    <a href="{{ $film->trailers->first()->link }}" target="_blank">
                        <img class="object-contain p-4" src="{{ $film->trailers->first()->image }}" />
                    </a>
                </div>
            @empty
                <div class="mt-4 border"">
                    None
                </div>
            @endforelse
        </div>
    </div>

    <div class="mt-8 bg-gray-200 h-auto shadow-md rounded-md p-6">
        <h3 class="font-bold text-xl">Watched</h2>

        <div class="flex flex-wrap">
            @forelse ($watchedFilms as $film)
                <div class="mt-4 border w-1/3" wire:key="{{ $loop->index }}">
                    <h4 class="font-bold pl-4 truncate">{{ $film->title }}</h4>

                    <a href="{{ $film->trailers->first()->link }}" target="_blank">
                        <img class="object-contain p-4" src="{{ $film->trailers->first()->image }}" />
                    </a>
                </div>
            @empty
                <div class="mt-4 border"">
                    None
                </div>
            @endforelse
        </div>
    </div>
</div>
