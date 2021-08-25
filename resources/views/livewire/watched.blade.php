<div class="max-w-6xl mx-auto">
    @forelse ($films as $film)
        @include ('livewire.partials._watchedFilm', ['film' => $film, 'loop' => $loop])
    @empty
        <div class="mt-4 border">
            <div class="font-bold text-lg">You have not reviewed any films</div>
        </div>
    @endforelse
</div>
