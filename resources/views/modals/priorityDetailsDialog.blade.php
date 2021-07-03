<div @click.away="close()" class="bg-white rounded shadow-lg p-4 w-1/3">
    <h1 class="text-center font-bold text-lg">{{ $film['title']}}</h1>

    <div x-data="{ level: '{{ $priority['level'] ?? 'low' }}', comment: '{{ $priority['comment'] ?? '' }}' }">
        <h2 class="text-center">Set priority</h2>

        <div class="flex justify-stretch mt-2">
            <button 
                class="w-1/3 bg-blue-200 hover:bg-blue-300"
                x-bind:class="{ 'border-2': level === 'low', 'border-blue-400': level === 'low', 'font-bold': level === 'low' }"
                @click="level = 'low'"
            >
                Low
            </button>

            <button 
                class="w-1/3 bg-yellow-300 hover:bg-yellow-400"
                x-bind:class="{ 'border-2': level === 'medium', 'border-yellow-500': level === 'medium', 'font-bold': level === 'medium' }"
                @click="level = 'medium'"
            >
                Medium
            </button>

            <button 
                class="w-1/3 bg-red-600 hover:bg-red-700"
                x-bind:class="{ 'border-2': level === 'high', 'border-red-800': level === 'high', 'font-bold': level === 'high' }"
                @click="level = 'high'"
            >
                High
            </button>
        </div>

        <div>
            <h2 class="text-center mt-2">Add a comment</h2>

            <textarea class="w-full h-32 mt-2 resize-y" x-model="comment"></textarea>
        </div>

        <div class="mt-4 flex justify-around">
            <button @click="$parent.close()">
                Cancel
            </button>
            <button @click="Livewire.emit('shortlist', {{ $film['id'] }}, level, comment); $parent.close()">
                Shortlist
            </button>
        </div>
    </div>
</div>
