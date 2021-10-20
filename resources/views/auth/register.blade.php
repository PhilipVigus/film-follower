<x-guest-layout>
    <x-auth-card>
        <div class="bg-gray-200 p-4 rounded shadow-sm lg:w-1/4 w-3/5">
            <x-auth-heading>Register</x-auth-heading>

            <x-errors />

            <form method="POST" action="{{ route('register') }}">
                @csrf
    
                <div class="mt-4">
                    <x-label for="name" value="Name" />
                    <x-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                </div>
    
                <div class="mt-4">
                    <x-label for="email" value="Email" />
                    <x-input id="email" type="email" name="email" :value="old('email')" required />
                </div>
    
                <div class="mt-4">
                    <x-label for="password" value="Password" />
                    <x-input id="password" type="password" name="password" required autocomplete="new-password" />
                </div>
    
                <div class="mt-4">
                    <x-label for="password_confirmation" value="Confirm Password" />
                    <x-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>

                <div class="mt-6">
                    <x-button class="w-full" type="submit">
                        Register
                    </x-button>
                </div>
    
                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                        Already registered?
                    </a>
                </div>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
