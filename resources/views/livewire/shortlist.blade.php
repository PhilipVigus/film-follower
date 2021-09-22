<x-film-list :films="$films" :searchKeys="$searchKeys" :highlightedFilmId="$highlightedFilmId">
    <x-slot name="buttons">
        <div class="mt-4 flex space-x-4">
            <x-button styling="secondary" x-on:click="$wire.emitTo('modal', 'open', 'remove-from-shortlist', { film: result.item })">Remove from shortlist</x-button>
            <x-button styling="primary" x-on:click="$wire.emitTo('modal', 'open', 'review-details', { film: result.item })">Review film</x-button>
        </div>
    </x-slot>

    <x-slot name="rightColumn">
        <div class="w-1/2">
            @include('livewire.partials._priority-details')
            @include('livewire.partials._tags')
            @include('livewire.partials._trailers')
        </div>
    </x-slot>
</x-film-list>
