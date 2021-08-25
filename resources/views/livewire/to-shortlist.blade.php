<div class="max-w-6xl mx-auto">
    @forelse ($films as $film)
        @include ('livewire.partials._toShortlistFilm', ['film' => $film, 'loop' => $loop])
    @empty
        <div class="mt-4 border">
            <div class="font-bold text-lg">You have no films to shortlist</div>
        </div>
    @endforelse
</div>
