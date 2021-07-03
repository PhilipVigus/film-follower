<div @click.away="close()" class="bg-white rounded shadow-lg p-4 w-1/3">
    <h1 class="text-center font-bold text-lg">{{ $film['title']}}</h1>

    <div x-data="{ deleteReviewDetails: true }">
        <div>
            <input type="checkbox" id="deleteReviewDetails" x-model="deleteReviewDetails"/>
            <label for="deleteReviewDetails">Delete review details</label><br>
        </div>

        <div class="mt-4 flex justify-around">
            <button @click="$parent.close()">
                Cancel
            </button>

            <button @click="Livewire.emit('remove-review', {{ $film['id'] }}, deleteReviewDetails); $parent.close()">
                Remove review
            </button>
        </div>
    </div>
</div>
