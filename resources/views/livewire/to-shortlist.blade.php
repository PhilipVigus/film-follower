<div 
    class="max-w-6xl mx-auto" 
    x-data="{ 
        films: {{ $films }},
        filterTerm: '',
        fuse: null,
        filmsPerSlice: 20,
        filmsShowing: 20
    }"
    x-init="
        fuse = new Fuse(films, { includeScore: true, useExtendedSearch: true, keys: ['title', 'tags.name', 'trailers.type'] });
        films = films.map((film) => {
            return { item: film };
        });
    "

>    <div class="mt-8 bg-gray-200 h-auto shadow-md overflow-hidden rounded-md p-6 flex items-center relative">

        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute right-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>

        <input class="w-full" type="search" placeholder="Search film titles" x-model="filterTerm"></input>
    </div>

    <template x-for="(result, index) in filterTerm ? fuse.search(filterTerm).slice(0, filmsShowing) : films.slice(0, filmsShowing)" :key="index">
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

                        if ((parseInt(this.$el.parentNode.getAttribute('data')) + 10) % 20 === 0) {
                            this.observer.observe(this.$el);
                        }
                    }
                }"
                x-init="observe()"
            ></div> 
        </article>
    </template>
</div>
