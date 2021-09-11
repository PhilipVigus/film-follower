<x-action-section>
    <x-slot name="content">
        <div class="text-sm text-gray-600">
            Once your account is deleted, all of your data will be permanently deleted and you will be unable to access the account again.
        </div>

        <div class="mt-4">
            <x-danger-button wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                Delete account
            </x-danger-button>
        </div>

        <!-- Delete User Confirmation Modal -->
        <x-jet-dialog-modal wire:model="confirmingUserDeletion">
            <x-slot name="title">
                Delete Account
            </x-slot>

            <x-slot name="content">
                Are you sure you want to delete your account? Once your account is deleted, all of your data will be permanently deleted and you will be unable to access the account again.

                <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-input type="password" class="mt-1 block w-3/4"
                                placeholder="Password"
                                x-ref="password"
                                wire:model.defer="password"
                                wire:keydown.enter="deleteUser" />

                    <x-input-error for="password" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                    Cancel
                </x-secondary-button>

                <x-danger-button class="ml-2" wire:click="deleteUser" wire:loading.attr="disabled">
                    Delete Account
                </x-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
    </x-slot>
</x-action-section>
