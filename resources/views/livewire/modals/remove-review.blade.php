<div x-data="{ deleteReviewDetails: true }">
    <h1 class="text-center font-bold text-lg">{{ $film['title']}}</h1>

    <div class="mt-2">
        <input type="checkbox" id="deleteReviewDetails" x-model="deleteReviewDetails"/>
        <label class="pl-1" for="deleteReviewDetails">Delete review details</label><br>
    </div>

    <div class="mt-4 flex justify-between space-x-4">
        <button class="w-full bg-gray-300 p-2 rounded-md hover:bg-gray-400" @click="$parent.close()">
            Cancel
        </button>

        <button class="w-full bg-blue-800 text-gray-100 p-2 rounded-md hover:bg-blue-900" x-on:click="$wire.removeReview({{ $film['id'] }}, deleteReviewDetails); $parent.close()">
            Remove review
        </button>
    </div>
</div>
