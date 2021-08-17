<div
    class="max-w-6xl mx-auto" 
>
    <div class="mt-8 bg-gray-200 h-auto shadow-md rounded-md p-6">
        <h2 class="font-bold text-2xl">Manage tags</h2>

        @include ('livewire.partials.ignoredFilmTags')
    </div>

    <div class="mt-8 bg-gray-200 h-auto shadow-md overflow-hidden rounded-md p-6">
        <h2 class="font-bold text-2xl">Top 50 tags by number of films</h2>
        
        <div>
            @foreach($mostCommonTags as $tag)
                <a href="{{ route('tag', ['tag' => $tag]) }}" class="inline-flex bg-gray-400 rounded-full px-2 py-1 mr-2 mt-1.5">{{ $tag->name }} x{{ $tag->films_count }}</a>
            @endforeach
        </div>
    </div>

    <div class="mt-8 bg-gray-200 h-auto shadow-md overflow-hidden rounded-md p-6">
        <h2 class="font-bold text-2xl">Ignored tags</h2>
        
        <div class="mt-2">
            <h3 class="font-bold text-xl">Film</h3>

            <template x-for="tag in tags.filter((t) => ignoredFilmTagIds.includes(t.id))" :key="tag.slug">
                <button class="inline-flex bg-gray-400 rounded-full px-2 py-1 mr-2 mt-1.5" x-text="tag.name" x-on:click="toggleIgnoredFilmTag(tag)"></button>
            </template>
        </div>

        <div class="mt-2">
            <h3 class="font-bold text-xl">Trailer</h3>

            @foreach($ignoredTrailerTags as $tag)
                <a href="{{ route('tag', ['tag' => $tag]) }}" class="inline-flex bg-gray-400 rounded-full px-2 py-1 mr-2 mt-1.5">{{ $tag->name }} x{{ $tag->films_count }}</a>
            @endforeach
        </div>
    </div>
</div>
