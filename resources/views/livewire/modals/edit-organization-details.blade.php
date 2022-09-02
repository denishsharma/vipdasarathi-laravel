<x-card>
    <x-slot name="header">
        <div class="px-4 py-2.5 flex justify-between items-center border-b dark:border-0 ">
            <h3 class="font-medium whitespace-normal text-md text-secondary-700 dark:text-secondary-400">
                @if ($actionType=='add')
                    Add Organization
                @elseif ($actionType=='edit')
                    Edit Organization
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
        <x-errors only="slug" class="col-span-2" title="Some problem occurred while submitting" />

        <x-input label="Name" placeholder="Enter organization name" wire:model="name" />
        <x-select
            label="Level"
            placeholder="Select level of organization"
            :options="[
                [ 'name' => 'National', 'value' => 'national' ],
                [ 'name' => 'State', 'value' => 'state' ],
                [ 'name' => 'District', 'value' => 'district' ],
                [ 'name' => 'Planning (Others)', 'value' => 'planning-others' ],
            ]"
            option-label="name"
            option-value="value"
            wire:model="level"
        />

        <div class="col-span-1 sm:col-span-2">
            <x-textarea label="Description" placeholder="Write something about your organization..." wire:model="description" />
        </div>
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <div class="flex justify-between gap-x-2">
                <x-button white label="Cancel" wire:click="$emit('closeModal')" />
                @if ($actionType == 'add')
                    <x-button positive spinner="addOrganization" label="Add Organization" wire:click="addOrganization" />
                @elseif ($actionType == 'edit')
                    <x-button positive label="Save Changes" spinner="updateOrganization" wire:click="updateOrganization" />
                @endif
            </div>
        </div>
    </x-slot>
</x-card>
