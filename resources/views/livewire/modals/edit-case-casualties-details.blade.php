<x-card>
    <x-slot name="header">
        <div class="px-4 py-2.5 flex justify-between items-center border-b dark:border-0 ">
            <h3 class="font-medium whitespace-normal text-md text-secondary-700 dark:text-secondary-400">
                Update Casualties
            </h3>
            <button class="focus:outline-none p-1 focus:ring-2 focus:ring-secondary-200 rounded-full text-secondary-300" wire:click="$emit('closeModal')" tabindex="-1">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </x-slot>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 soft-scrollbar">
        <x-errors class="col-span-2" title="Some problem occurred while submitting" />

        <x-input label="Deaths" type="number" min="0" placeholder="Enter count of dead victim" wire:model="deathCount" />
        <x-input label="Missing" type="number" min="0" placeholder="Enter count of missing victim" wire:model="missingCount" />

        <x-input label="Rescued" type="number" min="0" placeholder="Enter count of rescued victim" wire:model="rescuedCount" />
        <x-input label="Injured" type="number" min="0" :max="$rescuedCount" placeholder="Enter count of injured victim" wire:model="injuredCount" />
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <div class="flex justify-between gap-x-2">
                <x-button white label="Cancel" wire:click="$emit('closeModal')" />
                <x-button positive label="Update Casualties" spinner="updateCasualties" wire:click="updateCasualties" />
            </div>
        </div>
    </x-slot>
</x-card>
