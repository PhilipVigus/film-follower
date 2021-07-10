<div x-data="{ rating: '{{ $review['rating'] ?? '1' }}', comment: '{{ $review['comment'] ?? '' }}' }">
    <h1 class="text-center font-bold text-lg">{{ $film['title']}}</h1>
    
    <div>
        <h2 class="text-center">Set rating</h2>

        <select name="ratings" id="ratings" x-model="rating">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
    </div>

    <div>
        <h2 class="text-center mt-2">Add a comment</h2>

        <textarea class="w-full h-32 mt-2 resize-y" x-model="comment"></textarea>
    </div>

    <div class="mt-4 flex justify-around">
        <button @click="$parent.close()">
            Cancel
        </button>
        
        <button x-on:click="$wire.addReview({{ $film['id'] }}, rating, comment); $parent.close()">
            Save
        </button>
    </div>
</div>
