<x-form-section submit="updateProfileInformation">
    <x-slot name="form">
        <div>
            <x-label for="name" value="Name" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autocomplete="name" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <div>
            <x-label for="email" value="Email" />
            <x-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
            <x-input-error for="email" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            Saved
        </x-action-message>

        <x-auth-button wire:loading.attr="disabled" wire:target="photo">
            Save
        </x-auth-button>
    </x-slot>
</x-form-section>
