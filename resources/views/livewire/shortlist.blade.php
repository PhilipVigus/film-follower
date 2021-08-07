<div class="max-w-6xl mx-auto">
    @foreach ($films as $film)
        <article class="mt-8 bg-gray-200 h-auto shadow-md overflow-hidden rounded-md p-6" wire:key="{{ $loop->index }}">
            <h2 class="font-bold text-2xl">{{ $film->title }}</h2>

            <div class="flex space-x-6 mt-4">
                <section class="w-1/2">
                    <a href="{{ $film->trailers->first()->link }}" target="_blank">
                        <img class="flex-grow-0" src="{{ $film->trailers->first()->image }}" />
                    </a>

                    <div class="mt-4 flex space-x-4">
                    <button class="w-full bg-gray-300 p-2 rounded-md hover:bg-gray-400" wire:click="$emitTo('modal', 'open', 'remove-from-shortlist', { film: {{ $film }} })">Remove from shortlist</button>
                        <button class="w-full bg-blue-800 text-gray-100 p-2 rounded-md hover:bg-blue-900" wire:click="$emitTo('modal', 'open', 'review-details', { film: {{ $film }} })">Review film</button>
                    </div>
                </section>
                
                <div class="w-1/2">
                    <section class="bg-gray-400 rounded-md p-4 shadow-md">
                        <h3 class="font-bold text-lg">Rating</h3>

                        <div class="mt-2">
                            @for ($i=0; $i < $film->priorities->first()->rating; $i++)
                                <svg 
                                    xmlns="http://www.w3.org/2000/svg" 
                                    viewBox="0 0 20 20" 
                                    class="w-6 h-6 inline-block fill-current text-yellow-500"
                                    stroke="#6d4c41"
                                >
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>

                        <div class="mt-2">{{$film->priorities->first()->comment }}</div>
                    </section>

                    <section class="mt-2">
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
    @endforeach
</div>
