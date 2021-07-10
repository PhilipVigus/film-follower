<div x-data="{ deleteReviewDetails: true }">
    <h1 class="text-center font-bold text-lg">{{ $film['title']}}</h1>

    <div>
        <input type="checkbox" id="deleteReviewDetails" x-model="deleteReviewDetails"/>
        <label for="deleteReviewDetails">Delete review details</label><br>
    </div>

    <div class="mt-4 flex justify-around">
        <button @click="$parent.close()">
            Cancel
        </button>

        <button x-on:click="$wire.removeReview({{ $film['id'] }}, deleteReviewDetails); $parent.close()">
            Remove review
        </button>
    </div>
</div>
