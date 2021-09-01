<x-film-list :films="$films" :searchKeys="$searchKeys">
    <x-slot name="buttons">
        <div class="mt-4 flex space-x-4">
            <button class="w-full bg-blue-800 text-gray-100 p-2 rounded-md hover:bg-blue-900" x-on:click="$wire.unignoreFilm(result.item)">Unignore</button>
        </div>
    </x-slot>

    <x-slot name="userData">
        <div class="w-1/2">
            @include('livewire.partials._tags')
            @include('livewire.partials._trailers')
        </div>
    </x-slot>
</x-film-list>
