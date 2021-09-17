<nav x-data="{ open: false }" class="bg-gray-200 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <x-icons.camera class="w-20 h-20 p-2"/>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('to-shortlist') }}" :active="request()->routeIs('to-shortlist')">
                        To Shortlist
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('shortlist') }}" :active="request()->routeIs('shortlist')">
                        Shortlist
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('reviewed') }}" :active="request()->routeIs('reviewed')">
                        Reviewed
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('ignored') }}" :active="request()->routeIs('ignored')">
                        Ignored
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('tags') }}" :active="request()->routeIs('tags')">
                        Tags
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-end sm:ml-6">
                <div class="relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md" x-data="{ rotated: false }">
                                <button type="button" x-on:click="rotated = !rotated" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-600 hover:text-gray-700 focus:outline-none transition">
                                    {{ Auth::user()->name }}

                                    <svg :class="{ 'rotate-180': rotated }" class="ml-2 -mr-0.5 h-4 w-4 transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link href="{{ route('profile.show') }}">
                                Profile
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                    Log out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <div class="-mr-2 flex items-center sm:hidden bg-gray-200 text-green-700">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition">
                    <svg class="h-12 w-12 stroke-current fill-current text-gray-400" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2">
            <x-responsive-nav-link href="{{ route('to-shortlist') }}" :active="request()->routeIs('to-shortlist')">
                To shortlist
            </x-responsive-nav-link>
        </div>

        <div class="pt-2">
            <x-responsive-nav-link href="{{ route('shortlist') }}" :active="request()->routeIs('shortlist')">
                Shortlist
            </x-responsive-nav-link>
        </div>

        <div class="pt-2">
            <x-responsive-nav-link href="{{ route('reviewed') }}" :active="request()->routeIs('reviewed')">
                Reviewed
            </x-responsive-nav-link>
        </div>

        <div class="pt-2 border-b border-gray-300">
            <x-responsive-nav-link href="{{ route('ignored') }}" :active="request()->routeIs('ignored')">
                Ignored
            </x-responsive-nav-link>
        </div>

        <div class="pt-2">
            <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                Profile
            </x-responsive-nav-link>
        </div>

        <div class="pt-2">
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-responsive-nav-link href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                this.closest('form').submit();">
                    Log out
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</nav>
