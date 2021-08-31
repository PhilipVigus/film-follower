<div 
    class="max-w-6xl mx-auto" 
    x-data="{ 
        films: {{ $films }},
        searchTerm: '',
        currentTerm: '',
        fuse: null,
        filmsPerSlice: 10,
        filmsShowing: 10
    }"
    x-init="
        fuse = new Fuse(films, { includeScore: true, useExtendedSearch: true, keys: ['title', 'tags.name', 'trailers.type'] });
        films = films.map((film) => {
            return { item: film };
        });
    "
>    
    @include('livewire.partials._search')

    <template x-for="(result, index) in currentTerm ? fuse.search(currentTerm).slice(0, filmsShowing) : films.slice(0, filmsShowing)" :key="index">
        <article class="mt-8 bg-gray-200 h-auto shadow-md overflow-hidden rounded-md p-6" :index="index">
            <h2 class="font-bold text-2xl" x-text="result.item.title"></h2>

            <div class="flex space-x-6 mt-4">
                <section class="w-1/2">
                    <a :href="result.item.trailers[0].link" target="_blank">
                        <img class="flex-grow-0" :src="result.item.trailers[0].image" />
                    </a>
                    @include('livewire.partials._image-link')

                    <div class="mt-4 flex space-x-4">
                        <button class="w-full bg-gray-300 p-2 rounded-md hover:bg-gray-400" x-on:click="$wire.ignoreFilm(result.item)">Ignore</button>
                        <button class="w-full bg-blue-800 text-gray-100 p-2 rounded-md hover:bg-blue-900" x-on:click="$wire.emitTo('modal', 'open', 'priority-details', { film: result.item })">Shortlist</button>
                    </div>
                </section>

                <div class="w-1/2">
                    @include('livewire.partials._tags')
                    @include('livewire.partials._trailers')
                </div>
            </div>

            <div class="mt-4 border" x-show="!films.length">
                <div class="font-bold text-lg">None</div>
            </div>

            @include('livewire.partials._element-in-view-trigger')
        </article>
    </template>
</div>
