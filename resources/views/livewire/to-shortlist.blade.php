<div class="max-w-6xl mx-auto">
    <div class="mt-8 bg-gray-200 h-auto shadow-md overflow-hidden rounded-md p-6 flex items-center relative">

        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute right-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>

        <input class="w-full" type="search" placeholder="Search..."></input>
    </div>

    @forelse ($films as $film)
        @include ('livewire.partials._toShortlistFilm', ['film' => $film, 'loop' => $loop])
    @empty
        <div class="mt-4 border">
            <div class="font-bold text-lg">You have no films to shortlist</div>
        </div>
    @endforelse
</div>
