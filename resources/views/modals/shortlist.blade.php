<div @click.away="open = false; $dispatch('body-scroll', {})" class="bg-white rounded shadow-lg p-8 relative">
    {{ $film['guid'] }}
    <p>I'm a perfectly centered and focused modal. I'm not letting you scroll until you read me!</p>
    <button @click="open = false; $dispatch('toggle-background-scroll', {})">
        Cancel
    </button>
    <button @click="Livewire.emitTo('to-shortlist', 'shortlist', {{ $film['id'] }} ); open = false; $dispatch('toggle-background-scroll', {})">
        Shortlist
    </button>
</div>
