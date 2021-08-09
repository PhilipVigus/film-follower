<x-guest-layout>
    <x-auth-card>
        <div class="bg-gray-200 p-4 rounded shadow-sm w-1/5">
            <x-auth-heading>Log in</x-auth-heading>

            <x-auth-errors />
            
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mt-4">
                    <x-label for="email" value="Email" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" required autofocus :value="old('email')"/>
                </div>

                <div class="mt-4">
                    <x-label for="password" value="Password" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                </div>

                <div class="block mt-4 flex items-center justify-between">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" />
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                </div>

                <div>
                    <x-auth-button class="mt-4 w-full justify-center">
                        Log in
                    </x-auth-button>
                </div>
            </form>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="hidden">
                    <x-input id="guest_email" type="text" name="email" value="{{ config('film-follower.guest-email') }}"/>
                    <x-input id="guest_password" type="text" name="password" value="{{ config('film-follower.guest-password') }}"/>
                </div>

                <x-auth-button class="mt-4 w-full justify-center">
                    Log in as guest
                </x-auth-button>
            </form>

            <div class="flex items-center justify-between mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                    Don't have an account?
                </a>
            </div>
        </div>
    </x-auth-card>
</x-guest-layout>
