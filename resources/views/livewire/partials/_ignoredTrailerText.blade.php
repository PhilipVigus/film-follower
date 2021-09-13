<div
    x-data="{
        ignoredTrailerTitlePhrases: {{ $ignoredTrailerTitlePhrases }},
        phraseText: '',
        addPhrase() {
            if (this.phraseText.trim() !== '' && ! this.ignoredTrailerTitlePhrases.includes(this.phraseText.toLowerCase())) {
                this.ignoredTrailerTitlePhrases.push(this.phraseText.toLowerCase());
            }

            this.phraseText = '';
            return;
        },
        removePhrase(phraseToRemove) {
            this.ignoredTrailerTitlePhrases = this.ignoredTrailerTitlePhrases.filter((phrase) => {
                return phrase !== phraseToRemove.toLowerCase();   
            });
        }
    }"
>

    <p>Trailers with titles containing these phrases will not be shown. Films with no trailers visible will not show on any lists.</p>

    <template x-for="phrase in ignoredTrailerTitlePhrases" :key="phrase">
        <button class="inline-flex bg-green-300 rounded-full px-2 py-1 mr-2 mt-1.5" x-text="phrase" x-on:click="removePhrase(phrase)"></button>
    </template>

    <div class="flex mt-4 space-x-2">
        <input class="w-full" type="text" placeholder="Add phrases to ignore" x-model="phraseText"></input>
        <button class="bg-blue-800 text-gray-100 rounded-md hover:bg-blue-900 px-4" x-on:click="addPhrase()">Add</button>
    </div>
</div>
