<x-guest-layout>
    <x-auth-card>
        <div class="bg-gray-200 p-4 rounded shadow-sm w-1/5">
            <x-auth-heading>Register</x-auth-heading>

            <x-auth-errors />

            <form method="POST" action="{{ route('register') }}">
                @csrf
    
                <div>
                    <x-label for="name" value="Name" />
                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                </div>
    
                <div class="mt-4">
                    <x-label for="email" value="Email" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                </div>
    
                <div class="mt-4">
                    <x-label for="password" value="Password" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                </div>
    
                <div class="mt-4">
                    <x-label for="password_confirmation" value="Confirm Password" />
                    <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>

                <div>
                    <x-auth-button class="mt-6 w-full justify-center">
                        Register
                    </x-auth-button>
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
