<x-film-list :films="$films" :searchKeys="$searchKeys" :highlightedFilmId="$highlightedFilmId">
    <x-slot name="buttons">
        <div class="mt-4 flex space-x-4">
            <x-button class="w-full" styling="secondary" x-on:click="$wire.ignoreFilm(result.item)">Ignore</x-button>
            <x-button class="w-full" styling="primary" x-on:click="$wire.emitTo('modal', 'open', 'priority-details', { film: result.item })">Shortlist</x-button>
        </div>
    </x-slot>

    <x-slot name="rightColumn">
        <div class="w-1/2">
            @include('livewire.partials._tags')
            @include('livewire.partials._trailers')
        </div>
    </x-slot>
</x-film-list>
