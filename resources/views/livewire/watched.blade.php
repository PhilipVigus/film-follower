<x-film-list :films="$films" :searchKeys="$searchKeys" :highlightedFilmId="$highlightedFilmId">
    <x-slot name="buttons">
        <div class="mt-4 flex space-x-4">
            <button class="w-full bg-gray-300 p-2 rounded-md hover:bg-gray-400" x-on:click="$wire.emitTo('modal', 'open', 'remove-review', { film: result.item })">Remove review</button>
            <button class="w-full bg-blue-800 text-gray-100 p-2 rounded-md hover:bg-blue-900" x-on:click="$wire.emitTo('modal', 'open', 'review-details', { film: result.item })">Edit review</button>
        </div>
    </x-slot>

    <x-slot name="rightColumn">
        <div class="w-1/2">
            @include('livewire.partials._priority-details')
            @include('livewire.partials._review-details')
            @include('livewire.partials._tags')
            @include('livewire.partials._trailers')
        </div>
    </x-slot>
</x-film-list>
