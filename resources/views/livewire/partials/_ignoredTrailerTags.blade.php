<div 
    class="relative mt-4"
    x-data="{ 
        filterTerm: '',
        tags: {{ $allTags }},
        filteredTags: {{ $allTags }},
        ignoredTrailerTagIds: {{ $ignoredTrailerTagIds }},
        updateFilter() {
            this.filteredTags = this.tags.filter((tag) => {
                return tag.name.toLowerCase().includes(this.filterTerm.toLowerCase());
            });
        },
        toggleIgnoredTrailerTag(tag) {
            if (this.isIgnored(tag)) {
                const index = this.ignoredTrailerTagIds.indexOf(tag.id);
                this.ignoredTrailerTagIds.splice(index, 1);
            } else {
                this.ignoredTrailerTagIds.push(tag.id);
            }

            this.$wire.toggleIgnoredTrailerTag(tag);
        },
        isIgnored(tag) {
            return this.ignoredTrailerTagIds.includes(tag.id);
        }
    }"
>
    <h3 class="font-bold text-lg">Trailer</h3>

    <p>Trailers with these tags will not be under their film. Films with no displayed trailers will be hidden from all lists.</p>

    <template x-for="tag in tags.filter((t) => ignoredTrailerTagIds.includes(t.id))" :key="tag.slug">
        <button class="inline-flex bg-green-300 rounded-full px-2 py-1 mr-2 mt-1.5" x-text="tag.name" x-on:click="toggleIgnoredTrailerTag(tag)"></button>
    </template>

    <input class="w-full mb-2 mt-4" type="search"  placeholder="Search tags to add/remove from the list" x-model="filterTerm" x-on:input="updateFilter()"></input>

    <div class="bg-white border border-black rounded absolute w-full p-4 z-10" x-show="filterTerm !=''">
        <template x-for="tag in filteredTags" :key="tag.slug">
            <button 
                class="inline-flex bg-gray-400 rounded-full px-2 py-1 mr-2 mt-1.5"
                x-bind:class="{ 'bg-green-300': isIgnored(tag) }"
                x-text="tag.name" 
                x-on:click="toggleIgnoredTrailerTag(tag)"
            >
            </button>
        </template>
    </div>
</div>
