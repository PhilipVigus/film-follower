<section>
    <h3 class="font-bold text-lg">Tags</h3>

    <div>
        <template x-for="(tag, index) in result.item.tags" :key="index">
            <a class="whitespace-nowrap hover:bg-green-400 inline-flex bg-green-300 rounded-full px-2 py-1 mt-1.5" :href="'/tags/' + tag.slug" x-text="tag.name"></a>
        </template>
    </div>
</section>
