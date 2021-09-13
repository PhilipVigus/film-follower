<div 
    class="relative mt-4"
    x-data="{ 
        filterTerm: '',
        tags: {{ $allTags }},
        filteredTags: {{ $allTags }},
        ignoredFilmTagIds: {{ $ignoredFilmTagIds }},
        updateFilter() {
            this.filteredTags = this.tags.filter((tag) => {
                return tag.name.toLowerCase().includes(this.filterTerm.toLowerCase());
            });
        },
        toggleIgnoredFilmTag(tag) {
            if (this.isIgnored(tag)) {
                const index = this.ignoredFilmTagIds.indexOf(tag.id);
                this.ignoredFilmTagIds.splice(index, 1);
            } else {
                this.ignoredFilmTagIds.push(tag.id);
            }

            this.$wire.toggleIgnoredFilmTag(tag);
        },
        isIgnored(tag) {
            return this.ignoredFilmTagIds.includes(tag.id);
        }
    }"
>

    <p>Films with these tags will not be shown on your list of films to be shortlisted. Any films that you have already shortlisted or watched will still be displayed.</p>

    <template x-for="tag in tags.filter((t) => ignoredFilmTagIds.includes(t.id))" :key="tag.slug">
        <button class="inline-flex bg-green-300 rounded-full px-2 py-1 mr-2 mt-1.5" x-text="tag.name" x-on:click="toggleIgnoredFilmTag(tag)"></button>
    </template>
    
    <input class="w-full mt-4" type="search" placeholder="Search tags to add/remove from the list" x-model="filterTerm" x-on:input="updateFilter()"></input>

    <div class="bg-white border border-black rounded absolute w-full p-4 z-10" x-show="filterTerm !=''" x-cloak>
        <template x-for="tag in filteredTags" :key="tag.slug">
            <button 
                class="inline-flex bg-gray-400 rounded-full px-2 py-1 mr-2 mt-1.5"
                x-bind:class="{ 'bg-green-300': isIgnored(tag) }"
                x-text="tag.name" 
                x-on:click="toggleIgnoredFilmTag(tag)"
            >
            </button>
        </template>
    </div>

</div>
