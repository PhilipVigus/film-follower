<div class="max-w-6xl mx-auto">
    <div class="mt-8 bg-gray-200 h-auto shadow-md overflow-hidden rounded-md p-6">
        <h1 class="font-bold text-2xl">Top 50 tags by number of films</h1>
        
        <div>
            @foreach($tags as $tag)
                <a href="{{ route('tag', ['tag' => $tag]) }}" class="inline-flex bg-gray-400 rounded-full px-2 py-1 mr-2 mt-1.5">{{ $tag->name }} x{{ $tag->films_count }}</a>
            @endforeach
        </div>
    </div>
</div>
