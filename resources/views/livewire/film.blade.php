<div class="max-w-6xl mx-auto">
    <article class="mt-8 bg-gray-200 h-auto shadow-md overflow-hidden rounded-md p-6">

        <h2 class="font-bold text-2xl">{{ $film->title }}</h2>

        <div class="flex space-x-6 mt-4">
            <section class="w-1/2">
                <a href="{{ $film->trailers->first()->link }}" target="_blank">
                    <img class="flex-grow-0" src="{{ $film->trailers->first()->image }}" />
                </a>
            </section>

            <div class="w-1/2">
                @switch ($status)
                    @case (\App\Models\Film::TO_SHORTLIST)
                        <div>View film on list to shortlist</div>
                        @break
                    @case (\App\Models\Film::SHORTLISTED)
                        <div>View film on shortlist</div>
                        @break
                    @case (\App\Models\Film::WATCHED)
                        <div>View film review</div>
                        @break
                    @case (\App\Models\Film::IGNORED)
                        <div>View film on ignored list</div>
                        @break
                @endswitch
                <section>
                    <h3 class="font-bold text-lg">Tags</h3>

                    <div class="mt-2">
                        @forelse ($film->tags as $tag)
                            <a class="whitespace-nowrap hover:underline" href="{{ route('tag', ['tag' => $tag]) }}">{{ $tag->name }}</a>@if (! $loop->last),@endif
                        @empty
                            <span>
                                none
                            </span>
                        @endforelse
                    </div>
                </section>

                <section class="mt-4">
                    <h3 class="font-bold text-lg">Trailers</h3>

                    <ul class="">
                        @foreach ($film->trailers as $trailer)
                            <a href="{{ $trailer->link }}" target="_blank">
                                <li class="hover:underline">{{ $trailer->type }}</li>
                            </a>
                        @endforeach
                    </ul>
                </section>
            </div>
        </div>
    </article>
</div>
