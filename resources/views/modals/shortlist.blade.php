<div @click.away="open = false; $dispatch('body-scroll', {})" class="bg-white rounded shadow-lg p-8 relative">
    <button class="absolute right-0 top-0 px-3 py-1" @click="open = false; $dispatch('body-scroll', {})">
        x
    </button>
    {{ $film['guid'] }}
    <p>I'm a perfectly centered and focused modal. I'm not letting you scroll until you read me!</p>
</div>
