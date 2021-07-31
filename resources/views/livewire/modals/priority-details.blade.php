<div x-data="{ comment: @entangle('comment').defer, rating: @entangle('rating').defer }">
    <h1 class="text-center font-bold text-lg">{{ $film['title']}}</h1>
    
    <div>
        <h2 class="text-center">Set rating</h2>

        <select name="ratings" id="ratings" x-model="rating">
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>

        @error('rating') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div>
        <h2 class="text-center mt-2">Add a comment</h2>

        <textarea class="w-full h-32 mt-2 resize-y" x-model="comment"></textarea>
    </div>

    <div class="mt-4 flex justify-around">
        <button @click="$parent.close()">
            Cancel
        </button>
        
        <button x-on:click="$wire.submit()">
            Save
        </button>
    </div>
</div>
