<x-film-list :films="$films" :searchKeys="$searchKeys">
    <x-slot name="buttons">
        <div class="mt-4 flex space-x-4">
            <x-button class="w-full" styling="primary" x-on:click="$wire.unignoreFilm(result.item)">Unignore</x-button>
        </div>
    </x-slot>

    <x-slot name="rightColumn">
        <div class="w-full sm:w-1/2">
            @include('livewire.partials._tags')
            @include('livewire.partials._trailers')
        </div>
    </x-slot>
</x-film-list>
