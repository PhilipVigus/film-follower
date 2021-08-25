<div class="max-w-7xl mx-auto px-4">
    @forelse ($films as $film)
        @include ('livewire.partials._ignoredFilm', ['film' => $film, 'loop' => $loop])
    @empty
        <div class="mt-4 border">
            <div class="font-bold text-lg">You have not ignored any films</div>
        </div>
    @endforelse
</div>
