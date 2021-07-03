<div x-data="{ deletePriorityDetails: true }">
    <h1 class="text-center font-bold text-lg">{{ $film['title']}}</h1>
    <div>
        <input type="checkbox" id="deletePriorityDetails" x-model="deletePriorityDetails"/>
        <label for="deletePriorityDetails">Delete priority details</label><br>
    </div>

    <div class="mt-4 flex justify-around">
        <button @click="$parent.close()">
            Cancel
        </button>

        <button x-on:click="$wire.removeFromShortlist({{ $film['id'] }}, deletePriorityDetails); $parent.close()">
            Remove from shortlist
        </button>
    </div>
</div>
