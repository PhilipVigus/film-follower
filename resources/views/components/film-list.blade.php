@props(['searchKeys', 'films', 'highlightedFilmId' => 0])

<div 
    class="max-w-6xl mx-auto" 
    x-data="{ 
        films: {{ $films }},
        highlightedFilmId: {{ $highlightedFilmId }},
        searchTerm: '',
        currentTerm: '',
        fuse: null,
        filmsPerSlice: 10,
        filmsShowing: 10,
        isHighlightedFilm(index) {
            return this.highlightedFilmId !== 0 && index === 0
        }
    }"
    x-init="
        fuse = new Fuse(films, { includeScore: true, useExtendedSearch: true, keys: {{ $searchKeys }} });
        films = films.map((film) => {
            return { item: film };
        });
    "
>    
    @include('livewire.partials._search')

    <template x-for="(result, index) in currentTerm ? fuse.search(currentTerm).slice(0, filmsShowing) : films.slice(0, filmsShowing)" :key="index">
        <article class="mt-8 bg-gray-200 h-auto shadow-md overflow-hidden rounded-md p-6" :class="{'bg-yellow-100': isHighlightedFilm(index)}" :index="index">
            
            <div class="flex items-center space-x-2">
                <svg 
                    xmlns="http://www.w3.org/2000/svg" 
                    viewBox="0 0 20 20" 
                    class="w-8 h-8 inline-block fill-current text-yellow-500"
                    stroke="#6d4c41"
                    x-show="isHighlightedFilm(index)"
                >
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>

                <h2 class="font-bold text-2xl" x-text="result.item.title"></h2>

                <svg 
                    xmlns="http://www.w3.org/2000/svg" 
                    viewBox="0 0 20 20" 
                    class="w-8 h-8 inline-block fill-current text-yellow-500"
                    stroke="#6d4c41"
                    x-show="isHighlightedFilm(index)"
                >
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
            </div>

            <div class="flex flex-col sm:flex-row space-x-6 mt-4">
                <section class="w-full sm:w-1/2">                   
                    @include('livewire.partials._image-link')
                    {{ $buttons }}
                </section>

                {{ $rightColumn }}
            </div>

            @include('livewire.partials._element-in-view-trigger')
        </article>
    </template>
    
    @include('livewire.partials._empty-list')
</div>
