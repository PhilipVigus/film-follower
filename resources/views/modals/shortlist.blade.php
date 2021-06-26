<div @click.away="close()" class="bg-white rounded shadow-lg p-8 relative">
    <h1 class="text-center">{{ $film['title']}}</h1>
    <button @click="close()">
        Cancel
    </button>
    <button @click="Livewire.emitTo('to-shortlist', 'shortlist', {{ $film['id'] }} ); close()">
        Shortlist
    </button>
</div>
