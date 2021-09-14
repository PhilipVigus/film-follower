<section class="bg-gray-400 rounded-md p-4 shadow-md mb-4 relative">
    <h3 class="font-bold text-lg">Review</h3>
    
    <template x-for="(item) in Array.from(Array(result.item.reviews[0].rating))">
        <svg 
            xmlns="http://www.w3.org/2000/svg" 
            viewBox="0 0 20 20" 
            class="w-6 h-6 inline-block fill-current text-yellow-500"
            stroke="#6d4c41"
        >
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
        </svg>
    </template>

    <div class="mt-2" x-text="result.item.reviews[0].comment"></div>

    <button x-on:click="$wire.emitTo('modal', 'open', 'review-details', { film: result.item })">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 m-2 absolute top-0 right-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
    </button>
</section>
