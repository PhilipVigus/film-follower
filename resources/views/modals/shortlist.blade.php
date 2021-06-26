<div @click.away="close()" class="bg-white rounded shadow-lg p-4">
    <h1 class="text-center font-bold text-lg">{{ $film['title']}}</h1>

    <h2 class="text-center">Set priority</h2>

    <div class="flex justify-stretch mt-2">
        <button class="w-1/3 bg-blue-200 hover:bg-blue-300">Low</button>
        <button class="w-1/3 bg-yellow-300 hover:bg-yellow-400">Medium</button>
        <button class="w-1/3 bg-red-600 hover:bg-red-700">High</button>
    </div>

    <div class="mt-4 flex justify-around">
        <button @click="close()">
            Cancel
        </button>
        <button @click="Livewire.emitTo('to-shortlist', 'shortlist', {{ $film['id'] }} ); close()">
            Shortlist
        </button>
    </div>
</div>
