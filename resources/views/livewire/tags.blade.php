<div class="max-w-6xl mx-auto">
    <div class="mt-8 bg-gray-200 h-auto shadow-md rounded-md p-6">
        <h2 class="font-bold text-2xl">Manage ignored tags</h2>

        @include ('livewire.partials._ignoredFilmTags')
    </div>

    <div class="mt-8 bg-gray-200 h-auto shadow-md overflow-hidden rounded-md p-6">
        <h2 class="font-bold text-2xl">Top 50 tags</h2>
        
        <div>
            @foreach($mostCommonTags as $tag)
                <a wire:key="{{ $tag->id }}" href="{{ route('tag', ['tag' => $tag]) }}" class="inline-flex bg-gray-400 rounded-full px-2 py-1 mr-2 mt-1.5">{{ $tag->name }} x{{ $tag->films_count }}</a>
            @endforeach
        </div>
    </div>
</div>
