<div 
    class="max-w-6xl mx-auto" 
    x-data="{ 
        ignored: '{{ $ignored }}',
        toggleIgnore() {
            this.ignored = !this.ignored;
            this.$wire.toggleIgnoreTag();
        }
    }"
>
    <div class="mt-8 bg-gray-200 h-auto shadow-md rounded-md p-6 flex justify-between">
        <h2 class="font-bold text-2xl">Films tagged with '{{ $tag->name }}'</h2>
        <button class="bg-blue-800 text-gray-100 p-2 rounded-md hover:bg-blue-900 w-32" x-on:click="toggleIgnore()" x-text="ignored ? 'Unignore' : 'Ignore'"></button>
    </div>

    <div class="mt-8 bg-gray-200 h-auto shadow-md rounded-md p-6">
        <h3 class="font-bold text-xl">To shortlist</h2>

        @forelse ($filmsToShortlist as $film)
            @include ('livewire.partials._toShortlistFilm', ['film' => $film, 'loop' => $loop])
        @empty
            <div class="mt-4 border">
                <div class="font-bold text-lg">You have no films to shortlist</div>
            </div>
        @endforelse
    </div>

    <div class="mt-8 bg-gray-200 h-auto shadow-md rounded-md p-6">
        <h3 class="font-bold text-xl">Shortlisted</h2>

        @forelse ($shortlistedFilms as $film)
            @include ('livewire.partials._shortlistedFilm', ['film' => $film, 'loop' => $loop])
        @empty
            <div class="mt-4 border">
                <div class="font-bold text-lg">You have not shortlisted any films</div>
            </div>
        @endforelse
    </div>

    <div class="mt-8 bg-gray-200 h-auto shadow-md rounded-md p-6">
        <h3 class="font-bold text-xl">Watched</h2>

        @forelse ($watchedFilms as $film)
            @include ('livewire.partials._watchedFilm', ['film' => $film, 'loop' => $loop])
        @empty
            <div class="mt-4 border">
                <div class="font-bold text-lg">You have not reviewed any films</div>
            </div>
        @endforelse
    </div>
</div>
