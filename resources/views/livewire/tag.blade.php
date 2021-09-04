<div 
    class="max-w-6xl mx-auto" 
    x-data="{ 
        films: {{ $films }},
        baseUrl: '{{ url('/') }}',
        searchTerm: '',
        currentTerm: '',
        fuse: null,
        ignored: '{{ $ignored }}',
        toggleIgnore() {
            this.ignored = !this.ignored;
            this.$wire.toggleIgnoreTag(this.ignored);
        },
        getFilmLink(film) {
            const filmStatus = film.pivot.status;

            if (filmStatus === '{{ App\Models\Film::TO_SHORTLIST }}') {
                return `{{ route('to-shortlist') }}?film=${film.slug}`;
            }

            if (filmStatus === '{{ App\Models\Film::SHORTLISTED }}') {
                return `{{ route('shortlist') }}?film=${film.slug}`;
            }

            if (filmStatus === '{{ App\Models\Film::WATCHED }}') {
                return `{{ route('watched') }}?film=${film.slug}`;
            }
        }
    }"
    x-init="
        fuse = new Fuse(films, { includeScore: true, useExtendedSearch: true, keys: {{ $searchKeys }} });
        films = films.map((film) => {
            return { item: film };
        });
    "
>
    <div class="mt-8 bg-gray-200 h-auto shadow-md rounded-md p-6 flex justify-between">
        <h2 class="font-bold text-2xl">Films tagged with '{{ $tag->name }}'</h2>
        <button class="bg-blue-800 text-gray-100 p-2 rounded-md hover:bg-blue-900 w-32" x-on:click="toggleIgnore()" x-text="ignored ? 'Unignore' : 'Ignore'"></button>
    </div>

    @include('livewire.partials._search')

    <article class="mt-8 bg-gray-200 h-auto shadow-md overflow-hidden rounded-md p-4">
        <h2 class="text-2xl font-bold px-2 pt-2">Films to shortlist</h2>
        <div class="flex flex-wrap">
            <template x-for="(result, index) in currentTerm ? fuse.search(currentTerm).filter((film) => film.item.pivot.status === '{{ App\Models\Film::TO_SHORTLIST }}') : films.filter((film) => film.item.pivot.status === '{{ App\Models\Film::TO_SHORTLIST }}')" :key="index">
                <div :index="index" class="w-1/3 p-2">
                    <h3 class="truncate" x-text="result.item.title"></h2>

                    <div class="mt-4">
                        <a :href="getFilmLink(result.item)">
                            <img class="flex-grow-0" :src="result.item.trailers[0].image" />
                        </a>
                    </div>  
                </div>
            </template>
        </div>
        @include('livewire.partials._empty-list')
    </article>

    <article class="mt-8 bg-gray-200 h-auto shadow-md overflow-hidden rounded-md p-4">
        <h2 class="text-2xl font-bold px-2 pt-2">Shortlisted films</h2>
        <div class="flex flex-wrap">
            <template x-for="(result, index) in currentTerm ? fuse.search(currentTerm).filter((film) => film.item.pivot.status === '{{ App\Models\Film::SHORTLISTED }}') : films.filter((film) => film.item.pivot.status === '{{ App\Models\Film::SHORTLISTED }}')" :key="index">
                <div :index="index" class="w-1/3 p-2">
                    <h3 class="truncate" x-text="result.item.title"></h2>

                    <div class="mt-4">
                        <a :href="getFilmLink(result.item)">
                            <img class="flex-grow-0" :src="result.item.trailers[0].image" />
                        </a>
                    </div> 
                </div>
            </template>
        </div>
        @include('livewire.partials._empty-list')
    </article>

    <article class="mt-8 bg-gray-200 h-auto shadow-md overflow-hidden rounded-md p-4">
        <h2 class="text-2xl font-bold px-2 pt-2">Watched films</h2>
        <div class="flex flex-wrap">
            <template x-for="(result, index) in currentTerm ? fuse.search(currentTerm).filter((film) => film.item.pivot.status === '{{ App\Models\Film::WATCHED }}') : films.filter((film) => film.item.pivot.status === '{{ App\Models\Film::WATCHED }}')" :key="index">
                <div :index="index" class="w-1/3 p-2">
                    <h3 class="truncate" x-text="result.item.title"></h2>   

                    <div class="mt-4">
                        <a :href="getFilmLink(result.item)">
                            <img class="flex-grow-0" :src="result.item.trailers[0].image" />
                        </a>
                    </div> 
                </div>
            </template>
        </div>
        @include('livewire.partials._empty-list')
    </article>
</div>
