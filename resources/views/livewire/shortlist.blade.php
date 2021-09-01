<x-film-list :films="$films" :searchKeys="$searchKeys">
    <x-slot name="buttons">
        <div class="mt-4 flex space-x-4">
            <button class="w-full bg-gray-300 p-2 rounded-md hover:bg-gray-400" x-on:click="$wire.emitTo('modal', 'open', 'remove-from-shortlist', { film: result.item })">Remove from shortlist</button>
            <button class="w-full bg-blue-800 text-gray-100 p-2 rounded-md hover:bg-blue-900" x-on:click="$wire.emitTo('modal', 'open', 'review-details', { film: result.item })">Review film</button>
        </div>
    </x-slot>

    <x-slot name="userData">
        <div class="w-1/2">
            @include('livewire.partials._priority-details')
            @include('livewire.partials._tags')
            @include('livewire.partials._trailers')
        </div>
    </x-slot>
</x-film-list>
