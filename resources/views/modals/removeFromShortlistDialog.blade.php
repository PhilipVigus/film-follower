<div @click.away="close()" class="bg-white rounded shadow-lg p-4 w-1/3">
    <h1 class="text-center font-bold text-lg">{{ $film['title']}}</h1>

    <div x-data="{ deletePriorityDetails: true }">
        <div>
            <input type="checkbox" id="deletePriorityDetails" x-model="deletePriorityDetails"/>
            <label for="deletePriorityDetails">Delete priority details</label><br>
        </div>

        <div class="mt-4 flex justify-around">
            <button @click="$parent.close()">
                Cancel
            </button>

            <button @click="Livewire.emit('remove-from-shortlist', {{ $film['id'] }}, deletePriorityDetails); $parent.close()">
                Remove from shortlist
            </button>
        </div>
    </div>
</div>
