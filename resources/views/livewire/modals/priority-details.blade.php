<div x-data="{ comment: @entangle('comment').defer, rating: @entangle('rating').defer }">
    <h1 class="text-center font-bold text-lg">{{ $film['title']}}</h1>
    
    <div>
        <h2 class="text-center">How much do you want to see this film?</h2>
    </div>

    <div class="flex items-center justify-center">
        <template x-for="(item, index) in [...Array(5).keys()]" :key="index">
            <svg 
                xmlns="http://www.w3.org/2000/svg" 
                viewBox="0 0 20 20" 
                class="w-10 h-10 inline fill-current"
                :class="{ 'text-yellow-500': index < rating, 'text-white': index >= rating }"
                stroke="#6d4c41"
                x-on:click="rating = index + 1"
            >
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
        </template>

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
