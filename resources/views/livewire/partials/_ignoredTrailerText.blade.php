<div
    x-data="{
    ignoredTrailerTitlePhrases: {{ $ignoredTrailerTitlePhrases }}
    }"
>

    <p>Trailers with titles containing these phrases will not be shown. Films with no trailers visible will not show on any lists.</p>

    <template x-for="phrase in ignoredTrailerTitlePhrases" :key="phrase.phrase">
        <button class="inline-flex bg-green-300 rounded-full px-2 py-1 mr-2 mt-1.5" x-text="phrase.phrase" x-on:click=""></button>
    </template>

    <div class="flex mt-4 space-x-2">
        <input class="w-full" type="text" placeholder="Add phrases to ignore"></input>
        <button class="bg-blue-800 text-gray-100 rounded-md hover:bg-blue-900 px-4">Add</button>
    </div>
</div>
