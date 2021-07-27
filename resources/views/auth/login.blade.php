<x-guest-layout>
    <div class="bg-gray-900 h-screen w-screen flex items-center justify-center">
        <div class="bg-gray-200 p-4 rounded shadow-sm w-1/5" x-data="{ guest: false, oldEmail: '{{ old('email') }}' , test: 'value' }">
            <div class="flex items-center border-b border-gray-300 pb-2 justify-between">
                <x-icons.camera class="w-16 h-16"/>
                <h1 class="text-gray-900 text-2xl font-bold uppercase">
                    Log in
                </h1>
                <x-icons.camera class="w-16 h-16"/>
            </div>

            @if ($errors->any())
                <div class="mt-4 text-sm text-red-600 w-full">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mt-4">
                    <x-label for="email" value="Email" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" required autofocus x-bind:value="guest ? '{{ config('film-follower.guest-email') }}' : oldEmail"/>
                </div>

                <div class="mt-4">
                    <x-label for="password" value="Password" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" x-bind:value="guest ? 'password' : ''"/>
                </div>

                <div class="block mt-4 flex items-center justify-between">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" />
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>

                    <label for="guest_login" class="flex items-center">
                        <x-checkbox id="guest_login" name="guest" x-model="guest"/>
                        <span class="ml-2 text-sm text-gray-600">Log in as guest</span>
                    </label>
                </div>

                <div>
                    <x-button class="mt-4 w-full justify-center">
                        Log in
                    </x-button>
                </div>

                <div class="flex items-center justify-between mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                        Don't have an account?
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
