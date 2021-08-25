<div class="max-w-6xl mx-auto">
    <div class="mt-8 bg-gray-200 h-auto shadow-md rounded-md p-6">
        <h2 class="font-bold text-2xl">Films tagged with '{{ $tag->name }}'</h2>
    </div>

    <div class="mt-8 bg-gray-200 h-auto shadow-md rounded-md p-6">
        <h3 class="font-bold text-xl">To shortlist</h2>

        <div class="flex flex-wrap">
            @forelse ($filmsToShortlist as $film)
                @include ('livewire.partials._toShortlistFilm', ['film' => $film, 'loop' => $loop])
            @empty
                <div class="mt-4 border">
                    <div class="font-bold text-lg">You have no films to shortlist</div>
                </div>
            @endforelse
        </div>
    </div>

    <div class="mt-8 bg-gray-200 h-auto shadow-md rounded-md p-6">
        <h3 class="font-bold text-xl">Shortlisted</h2>

        <div class="flex flex-wrap">
            @forelse ($shortlistedFilms as $film)
                @include ('livewire.partials._shortlistedFilm', ['film' => $film, 'loop' => $loop])
            @empty
                <div class="mt-4 border">
                    <div class="font-bold text-lg">You have not shortlisted any films</div>
                </div>
            @endforelse
        </div>
    </div>

    <div class="mt-8 bg-gray-200 h-auto shadow-md rounded-md p-6">
        <h3 class="font-bold text-xl">Watched</h2>

        <div class="flex flex-wrap">
        @forelse ($watchedFilms as $film)
            @include ('livewire.partials._watchedFilm', ['film' => $film, 'loop' => $loop])
        @empty
            <div class="mt-4 border">
                <div class="font-bold text-lg">You have not reviewed any films</div>
            </div>
        @endforelse
        </div>
    </div>
</div>
