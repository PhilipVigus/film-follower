<div class="mt-8 bg-gray-200 h-auto shadow-md overflow-hidden rounded-md p-6 flex items-center relative">
    <div class="flex w-full items-center">
        <input class="flex-1 rounded-l-md" type="text" placeholder="Search..." x-model="searchTerm" x-on:keydown.enter ="currentTerm = searchTerm"></input>
        
        <button class="bg-blue-800 text-gray-100 p-2 rounded-r-md hover:bg-blue-700 border border-blue-800 hover:border-blue-700" x-on:click="currentTerm = searchTerm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </button>
    </div>
</div>
