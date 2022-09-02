<x-card>
    <x-slot name="header">
        <div class="px-4 py-2.5 flex justify-between items-center border-b dark:border-0 ">
            <h3 class="font-medium whitespace-normal text-md text-secondary-700 dark:text-secondary-400">
                @if($actionType == 'add')
                    Add User
                @elseif($actionType == 'edit')
                    Edit User
                @endif
            </h3>
            <button class="focus:outline-none p-1 focus:ring-2 focus:ring-secondary-200 rounded-full text-secondary-300" wire:click="$emit('closeModal')" tabindex="-1">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 soft-scrollbar">
        <x-input label="First name" placeholder="Enter first name" wire:model="firstName" />
        <x-input label="Last name" placeholder="Enter last name" wire:model="lastName" />

        <x-input label="Mobile Number" placeholder="Enter mobile number" wire:model="mobile" />
        <x-select
            label="Organization"
            placeholder="Select organization"
            :async-data="route('api.organization.all')"
            option-label="name"
            option-value="slug"
            option-description="level"
            wire:model="organization"
            :selected="$organization"
        />

        <div class="col-span-1 sm:col-span-2 mt-2">
            <h4 class="block text-md font-semibold text-gray-700 mb-2.2">Authentication Details</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <x-input label="Email" placeholder="Enter email address" wire:model="email" />
                <x-input label="Password" type="password" placeholder="Enter password" wire:model.defer="password" />
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <div class="flex justify-between gap-x-2">
                <x-button white label="Cancel" wire:click="$emit('closeModal')" />
                @if($actionType == 'add')
                    <x-button positive spinner="addUser" label="Add User" wire:click="addUser" />
                @elseif($actionType == 'edit')
                    <x-button positive label="Save Changes" spinner="updateUser" wire:click="updateUser" />
                @endif
            </div>
        </div>
    </x-slot>
</x-card>
