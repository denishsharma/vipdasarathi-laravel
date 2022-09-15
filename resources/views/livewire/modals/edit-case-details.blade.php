<x-card>
    <x-slot name="header">
        <div class="px-4 py-2.5 flex justify-between items-center border-b dark:border-0 ">
            <h3 class="font-medium whitespace-normal text-md text-secondary-700 dark:text-secondary-400">
                @if ($actionType=='add')
                    Add Case
                @elseif ($actionType=='edit')
                    Edit Case Details
                @endif
            </h3>
            <button class="focus:outline-none p-1 focus:ring-2 focus:ring-secondary-200 rounded-full text-secondary-300" wire:click="$emit('closeModal')" tabindex="-1">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </x-slot>
    <div class="grid grid-cols-2 gap-4 soft-scrollbar">
        <x-errors only="slug" class="col-span-2" title="Some problem occurred while submitting" />

        <div class="col-span-2">
            <x-input label="Title" placeholder="Enter case title" wire:model="title" />
        </div>

        <div class="col-span-2">
            <x-textarea label="Description" placeholder="Enter description for the case" wire:model="description" />
        </div>

        <div class="col-span-1 sm:col-span-2 mt-2">
            <h4 class="block text-md font-semibold text-gray-700 mb-2.2">Locations</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="col-span-1 sm:col-span-2">
                    <x-input label="Address Line" placeholder="Enter address line" wire:model="addressLine" />
                </div>
                <x-input label="Zipcode" placeholder="Enter zipcode" wire:model="zipcode" />
                <x-input label="City" placeholder="Enter City" wire:model="city" />
                <x-input label="District" placeholder="Enter District" wire:model="district" />
                <x-select
                    label="State"
                    placeholder="Select State"
                    :async-data="route('api.states.all')"
                    option-label="name"
                    option-value="id"
                    wire:model="state" />
            </div>
        </div>

        <div class="col-span-1 sm:col-span-2 mt-2">
            <h4 class="block text-md font-semibold text-gray-700 mb-2.2">Case Details</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <x-select
                    label="Type of disaster"
                    placeholder="Select type of disaster"
                    :async-data="route('api.disaster-type.all')"
                    option-label="name"
                    option-value="slug"
                    wire:model="disasterType" />

                <x-select
                    label="SOP"
                    Placeholder="Select SOP"
                    :options="[
                        ['name' => 'SOP 2022', 'value' => '1'],
                        ['name' => 'SOP 2021', 'value' => '2'],
                        ['name' => 'SOP 2020', 'value' => '3'],
                        ['name' => 'SOP 2019', 'value' => '4'],
                        ['name' => 'SOP 2018', 'value' => '5']
                    ]"
                    option-label="name"
                    option-value="value"
                    wire:model="selectedSop" />

                <x-select
                    label="Priority"
                    Placeholder="Select Priority"
                    :options="[
                        ['name' => 'Urgent', 'value' => 'urgent'],
                        ['name' => 'High', 'value' => 'high'],
                        ['name' => 'Medium', 'value' => 'medium'],
                        ['name' => 'Low', 'value' => 'low']
                    ]"
                    option-label="name"
                    option-value="value"
                    wire:model="priority" />

                <x-datetime-picker without-timezone label="Date and Time" placeholder="Select Date and Time" wire:model="happenedAt" />
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <div class="flex justify-between gap-x-2">
                <x-button white label="Cancel" wire:click="$emit('closeModal')" />
                @if ($actionType == 'add')
                    <x-button positive spinner="addCase" label="Add Case" wire:click="addCase" />
                @elseif ($actionType == 'edit')
                    <x-button positive label="Save Changes" spinner="updateCase" wire:click="updateCase" />
                @endif
            </div>
        </div>
    </x-slot>
</x-card>
