<div 
    class="max-w-6xl mx-auto" 
    x-data="{ 
        films: {{ $films }},
        filterTerm: ''
    }"
>
    <div class="mt-8 bg-gray-200 h-auto shadow-md overflow-hidden rounded-md p-6 flex items-center relative">

        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute right-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>

        <input class="w-full" type="search" placeholder="Search..." x-model="filterTerm"></input>
    </div>

    <template x-for="(film, index) in films.filter(film => film.title.toLowerCase().includes(filterTerm.toLowerCase()))" :key="index">
        <article class="mt-8 bg-gray-200 h-auto shadow-md overflow-hidden rounded-md p-6">
            <h2 class="font-bold text-2xl" x-text="film.title"></h2>

            <div class="flex space-x-6 mt-4">
                <section class="w-1/2">
                    <a :href="film.trailers[0].link" target="_blank">
                        <img class="flex-grow-0" :src="film.trailers[0].image" />
                    </a>


                    <div class="mt-4 flex space-x-4">
                        <button class="w-full bg-gray-300 p-2 rounded-md hover:bg-gray-400" x-on:click="$wire.ignoreFilm(film)">Ignore</button>
                        <button class="w-full bg-blue-800 text-gray-100 p-2 rounded-md hover:bg-blue-900" x-on:click="$wire.emitTo('modal', 'open', 'priority-details', { film: film })">Shortlist</button>
                    </div>
                </section>

                <div class="w-1/2">
                    <section>
                        <h3 class="font-bold text-lg">Tags</h3>

                        <div class="mt-2">
                            <template x-for="(tag, index) in film.tags" :key="index">
                                <a class="whitespace-nowrap hover:underline" :href="'/tags/' + tag.slug" x-text="tag.name"></a>
                            </template>
                        </div>
                    </section>

                    <section class="mt-4">
                        <h3 class="font-bold text-lg">Trailers</h3>

                        <ul>
                            <template x-for="(trailer, index) in film.trailers" :key="index">
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
        </article>
    </template>
</div>
