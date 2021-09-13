<div 
    class="relative mt-4"
    x-data="{ 
        filterTerm: '',
        tags: {{ $allTags }},
        filteredTags: {{ $allTags }},
        updateFilter() {
            this.filteredTags = this.tags.filter((tag) => {
                return tag.name.toLowerCase().includes(this.filterTerm.toLowerCase());
            });
        },
        getTagLink(tag) {
            return `{{ url('/') }}/tags/${tag.slug}`
        }
    }"
>   
    <p>Search all tags currently used by films in the database.</p>

    <input class="w-full mt-2" type="search" placeholder="Search tags" x-model="filterTerm" x-on:input="updateFilter()"></input>

    <div class="bg-white border border-black rounded absolute w-full p-4 z-10" x-show="filterTerm !=''" x-cloak>
        <template x-for="(tag, index) in filteredTags" :key="tag.slug">
            <a :index="index" :href="getTagLink(tag)" class="inline-flex bg-gray-400 rounded-full px-2 py-1 mr-2 mt-1.5" x-text="tag.name + ' x ' + tag.films_count"></a>
        </template>
    </div>

</div>
