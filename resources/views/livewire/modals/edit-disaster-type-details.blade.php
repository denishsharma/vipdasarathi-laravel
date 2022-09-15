<x-card>
    <x-slot name="header">
        <div class="px-4 py-2.5 flex justify-between items-center border-b dark:border-0 ">
            <h3 class="font-medium whitespace-normal text-md text-secondary-700 dark:text-secondary-400">
                @if ($actionType=='add')
                    Add Disaster Type
                @elseif ($actionType=='edit')
                    Edit Disaster Type
                @endif
            </h3>
            <button class="focus:outline-none p-1 focus:ring-2 focus:ring-secondary-200 rounded-full text-secondary-300" wire:click="$emit('closeModal')" tabindex="-1">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </x-slot>
    <div class="grid grid-cols-1 sm:grid-cols-1 gap-4 soft-scrollbar">
        <x-errors only="slug" class="col-span-1" title="Some problem occurred while submitting" />

        <x-input label="Type Name" placeholder="Enter disaster type name" wire:model="name" />
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <div class="flex justify-between gap-x-2">
                <x-button white label="Cancel" wire:click="$emit('closeModal')" />
                @if ($actionType == 'add')
                    <x-button positive spinner="addDisasterType" label="Add Disaster Type" wire:click="addDisasterType" />
                @elseif ($actionType == 'edit')
                    <x-button positive label="Save Changes" spinner="updateDisasterType" wire:click="updateDisasterType" />
                @endif
            </div>
        </div>
    </x-slot>
</x-card>
