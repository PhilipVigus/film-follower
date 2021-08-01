<div 
    x-data="{ 
        comment: @entangle('comment').defer,
        rating: @entangle('rating').defer,
        hoverRating: {{ $rating }},
        maxRating: 5,
        isFullyFilled(position) {
            return position <= this.rating && position <= this.hoverRating;
        },
        isFullyEmpty(position) {
            return position > this.rating && position > this.hoverRating;
        },
        isCandidateEmpty(position) {
            return position <= this.rating && position > this.hoverRating;
        },
        isCandidateFilled(position) {
            return position > this.rating && position <= this.hoverRating;
        },
    }"
>
    <h1 class="text-center font-bold text-lg bg-gray-700 text-white p-2">{{ $film['title']}}</h1>
    
    <div class="p-4">
        <div class="mt-2">
            <p class="text-center">How much do you want to see this film?</p>

            <div class="flex items-center justify-center mt-2">
                <template x-for="(item, index) in [...Array(maxRating).keys()]" :key="index">
                    <svg 
                        xmlns="http://www.w3.org/2000/svg" 
                        viewBox="0 0 20 20" 
                        class="w-10 h-10 inline fill-current"
                        :class="{ 
                            'text-yellow-500': isFullyFilled(index + 1),
                            'text-white': isFullyEmpty(index + 1),
                            'text-yellow-200': isCandidateEmpty(index + 1),
                            'text-yellow-300': isCandidateFilled(index + 1) 
                        }"
                        x-on:click="rating = index + 1"
                        x-on:mouseenter="hoverRating = index + 1"
                        x-on:mouseleave="hoverRating = rating"
                        stroke="#6d4c41"
                    >
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </template>
            </div>
            @error('rating') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="mt-2">
            <label for="comment">
                Add a comment
                <textarea name="comment" class="w-full h-32 mt-2 resize-y" x-model="comment"></textarea>
            </label>
        </div>

        <div class="mt-4 flex space-x-4">
            <button @click="$parent.close()" class="w-full bg-gray-300 p-2 rounded-md hover:bg-gray-400">
                Cancel
            </button>
            
            <button x-on:click="$wire.submit()" class="w-full bg-blue-800 text-gray-100 p-2 rounded-md hover:bg-blue-900">
                Save
            </button>
        </div>
    </div>
</div>
