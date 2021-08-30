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

>    <div class="mt-8 bg-gray-200 h-auto shadow-md overflow-hidden rounded-md p-6 flex items-center relative">
        <div class="flex w-full items-center space-x-2">
            <input class="flex-1" type="search" placeholder="Search films" x-model="searchTerm"></input>
            <button class="bg-blue-800 text-gray-100 p-2 rounded-md hover:bg-blue-900" x-on:click="currentTerm = searchTerm">Search</button>
        </div>
    </div>

    <template x-for="(result, index) in currentTerm ? fuse.search(currentTerm).slice(0, filmsShowing) : films.slice(0, filmsShowing)" :key="index">
        <article class="mt-8 bg-gray-200 h-auto shadow-md overflow-hidden rounded-md p-6" :data="index">
            <h2 class="font-bold text-2xl" x-text="result.item.title"></h2>

            <div class="flex space-x-6 mt-4">
                <section class="w-1/2">
                    <a :href="result.item.trailers[0].link" target="_blank">
                        <img class="flex-grow-0" :src="result.item.trailers[0].image" />
                    </a>


                    <div class="mt-4 flex space-x-4">
                        <button class="w-full bg-gray-300 p-2 rounded-md hover:bg-gray-400" x-on:click="$wire.ignoreFilm(result.item)">Ignore</button>
                        <button class="w-full bg-blue-800 text-gray-100 p-2 rounded-md hover:bg-blue-900" x-on:click="$wire.emitTo('modal', 'open', 'priority-details', { film: result.item })">Shortlist</button>
                    </div>
                </section>

                <div class="w-1/2">
                    <section>
                        <h3 class="font-bold text-lg">Tags</h3>

                        <div>
                            <template x-for="(tag, index) in result.item.tags" :key="index">
                                <a class="whitespace-nowrap hover:bg-green-400 inline-flex bg-green-300 rounded-full px-2 py-1 mt-1.5" :href="'/tags/' + tag.slug" x-text="tag.name"></a>
                            </template>
                        </div>
                    </section>

                    <section class="mt-4">
                        <h3 class="font-bold text-lg">Trailers</h3>

                        <ul>
                            <template x-for="(trailer, index) in result.item.trailers" :key="index">
                                <a :href="trailer.link" target="_blank">
                                    <li class="hover:underline" x-text="trailer.type"></li>
                                </a>
                            </template>
                        </ul>
                    </section>
                </div>
            </div>

            <div class="mt-4 border" x-show="!films.length">
                <div class="font-bold text-lg">You have no films to shortlist</div>
            </div>
            <div
                x-data="{
                    observer: null,
                    observe () {
                        this.observer = new IntersectionObserver((entries) => {
                            entries.forEach(entry => {
                                if (entry.isIntersecting) {
                                    $parent.filmsShowing += $parent.filmsPerSlice;
                                    this.observer.unobserve(entry.target);
                                }
                            })
                        }, {
                            root: null
                        })

                        if ((parseInt(this.$el.parentNode.getAttribute('data')) + 10) % 10 === 0) {
                            this.observer.observe(this.$el);
                        }
                    }
                }"
                x-init="observe()"
            ></div> 
        </article>
    </template>
</div>
