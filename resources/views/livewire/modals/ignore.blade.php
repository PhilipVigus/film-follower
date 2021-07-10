<div x-data="{ deleteReviewDetails: true }">
    <h1 class="text-center font-bold text-lg">{{ $film['title']}}</h1>

    <div class="mt-4 flex justify-around">
        <button @click="$parent.close()">
            Cancel
        </button>

        <button x-on:click="$wire.ignoreFilm({{ $film['id'] }}); $parent.close()">
            Ignore
        </button>
    </div>
</div>
