<div x-data="{ deletePriorityDetails: true }">
    <h1 class="text-center font-bold text-lg">{{ $film['title']}}</h1>

    <div class="mt-2">
        <input type="checkbox" id="deletePriorityDetails" x-model="deletePriorityDetails"/>
        <label class="pl-1" for="deletePriorityDetails">Delete priority details</label><br>
    </div>

    <div class="mt-4 flex justify-between space-x-4">
        <button class="w-full bg-gray-300 p-2 rounded-md hover:bg-gray-400" @click="$parent.close()">
            Cancel
        </button>

        <button class="w-full bg-blue-800 text-gray-100 p-2 rounded-md hover:bg-blue-900" x-on:click="$wire.removeFromShortlist({{ $film['id'] }}, deletePriorityDetails); $parent.close()">
            Remove from shortlist
        </button>
    </div>
</div>
