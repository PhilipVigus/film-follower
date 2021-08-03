<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4">
            @foreach ($films as $film)
                <div class="mt-4 bg-gray-200 h-56 shadow-lg relative z-0 overflow-hidden" wire:key="{{ $loop->index }}">
                    <div class="flex">
                        <a href="{{ $film->trailers->first()->link }}" target="_blank">
                            <img class="h-56 flex-grow-0" src="{{ $film->trailers->first()->image }}" />
                        </a>
                        
                        <div class="w-3/5 border-r border-gray-300 flex flex-col justify-between p-4" :class="{ 'filter blur': ignored }">
                            <div>
                                <h2 class="font-bold text-2xl">{{ $film->title }}</h2>

                                <div class="mt-2 h-max flex-grow">
                                    @forelse ($film->tags as $tag)
                                        <a class="whitespace-nowrap" href="{{ route('tag', ['tag' => $tag]) }}">{{ $tag->name }}</a>@if (! $loop->last),@endif
                                    @empty
                                        <span>
                                            none
                                        </span>
                                    @endforelse
                                </div>
                            </div>

                            <div class="flex">
                                <div>
                                    <div class="mt-2">
                                        @for ($i=0; $i < $film->priorities->first()->rating; $i++)
                                            <svg 
                                                xmlns="http://www.w3.org/2000/svg" 
                                                viewBox="0 0 20 20" 
                                                class="w-10 h-10 inline fill-current text-yellow-500"
                                                stroke="#6d4c41"
                                            >
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>

                                    <div>{{$film->priorities->first()->comment }}</div>
                                </div>

                                <div>
                                    <button wire:click="$emitTo('modal', 'open', 'priority-details', { film: {{ $film }} })">Edit details</button>
                                </div>
                            </div>

                            <div class="flex space-x-4">
                                <button class="w-full bg-gray-300 p-2 rounded-md hover:bg-gray-400" wire:click="$emitTo('modal', 'open', 'remove-from-shortlist', { film: {{ $film }} })">Remove from shortlist</button>
                                <button class="w-full bg-blue-800 text-gray-100 p-2 rounded-md hover:bg-blue-900" wire:click="$emitTo('modal', 'open', 'review-details', { film: {{ $film }} })">Review film</button>
                            </div>
                        </div>

                        <div class="flex-grow-0 w-80 p-4" :class="{ 'filter blur': ignored }">
                            <h3 class="font-bold text-lg">Trailers</h2>

                            <div class="mt-2">
                                @foreach ($film->trailers as $trailer)
                                    <a href="{{ $trailer->link }}" target="_blank">
                                        <div class="truncate">{{ $trailer->type }}</div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
