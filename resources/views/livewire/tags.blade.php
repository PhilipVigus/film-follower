<div
    class="max-w-6xl mx-auto" 
    x-data="{ 
        filterTerm: '',
        tags: {{ $allTags }},
        filteredTags: {{ $allTags }},
        ignoredFilmTags: {{ $ignoredFilmTags }},
        updateFilter() {
            this.filteredTags = this.tags.filter((tag) => {
                return tag.name.toLowerCase().includes(this.filterTerm.toLowerCase());
            });
        },
        toggleIgnoredFilmTag(tag) {
            let filmTagToRemove = null;

            this.ignoredFilmTags.forEach((filmTag) => {
                if (filmTag.id === tag.id) {
                    filmTagToRemove = filmTag;
                    return;
                }
            });


            if (filmTagToRemove) {
                const index = this.ignoredFilmTags.indexOf(filmTagToRemove);
                this.ignoredFilmTags.splice(index, 1);
            } else {
                this.ignoredFilmTags.push(tag);
            }

            this.$wire.toggleIgnoredFilmTag(tag);
        }
    }"
>
    <div class="mt-8 bg-gray-200 h-auto shadow-md rounded-md p-6">
        <div class="relative">   
            <input class="w-full mb-2" type="search" x-model="filterTerm" x-on:input="updateFilter()"></input>

            <div class="bg-white border border-black rounded absolute w-full p-4" x-show="filterTerm !=''">
                <template x-for="tag in filteredTags" :key="tag.slug">
                    <button 
                        class="inline-flex bg-gray-400 rounded-full px-2 py-1 mr-2 mt-1.5"
                        x-bind:class="{ 'bg-green-300': ignoredFilmTags.includes(tag) }"
                        x-text="tag.name" 
                        x-on:click="toggleIgnoredFilmTag(tag)"
                    >
                    </button>
                </template>
            </div>
        </div>
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

            <template x-for="tag in ignoredFilmTags" :key="tag.slug">
                <button class="inline-flex bg-gray-400 rounded-full px-2 py-1 mr-2 mt-1.5" x-text="tag.name" ></button>
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
