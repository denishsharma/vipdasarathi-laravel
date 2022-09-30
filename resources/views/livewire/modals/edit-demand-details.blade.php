<x-card>
    <x-slot name="header">
        <div class="px-4 py-2.5 flex justify-between items-center border-b dark:border-0 ">
            <h3 class="font-medium whitespace-normal text-md text-secondary-700 dark:text-secondary-400">
                @if ($actionType=='add')
                    Add Demand
                @elseif ($actionType=='edit')
                    Edit Demand Details
                @elseif ($actionType=='task')
                    Take decision and create task
                @elseif($actionType=='view')
                    View Demand Details
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
        <x-errors only="slug" class="col-span-1" title="Some problem occurred while submitting" />

        @if ($actionType === 'add' or $actionType === 'edit')
            <div class="col-span-2">
                <x-input label="Demand Subject" placeholder="Enter demand subject or title" wire:model="subject" />
            </div>

            <x-select
                label="Created By"
                placeholder="Select user who created this demand"
                :async-data="route('api.user.all')"
                option-label="name"
                option-description="email"
                option-value="slug"
                hide-empty-message
                :clearable="false"
                wire:model="createdBy" />

            <x-select
                label="Demand Type"
                placeholder="Select type of demand"
                :async-data="route('api.demand-type.all')"
                option-label="name"
                option-value="slug"
                wire:model="demandType" />

            <div class="col-span-2">
                <x-textarea label="Description" placeholder="Write something about type..." wire:model="description" />
            </div>

            <div class="col-span-1 sm:col-span-2 mt-2">
                <h4 class="block text-md font-semibold text-gray-700 mb-2.2">Manage Items</h4>
                <div class="grid grid-cols-6 gap-4 mb-2.5">
                    <div class="col-span-3">
                        <x-input placeholder="Enter item name" wire:model="itemName" />
                    </div>
                    <div class="col-span-2">
                        <x-input placeholder="Quantity" type="number" min="0" wire:model="itemQuantity" />
                    </div>
                    <x-button class="justify-self-start" label="Add Item" wire:click="addItem" />
                </div>

                @if (count($items) > 0)
                    <div class="">
                        <ul role="list" class="overflow-y-auto soft-scrollbar max-h-40 border border-gray-200 rounded-md divide-y divide-gray-200">
                            @foreach($items as $item)
                                <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                    <div class="w-0 flex-1 flex items-center">
                                        <x-icon name="archive" class="w-5 h-5 flex-shrink-0 text-gray-400" />
                                        <span class="ml-2 flex-1 w-0 truncate"><span class="font-medium">{{ $item['name'] }}</span> <span class="text-gray-400">({{ $item['quantity'] }} Quantity)</span></span>
                                    </div>
                                    <div class="ml-4 flex-shrink-0">
                                        <a wire:click="removeItem('{{ $item['key'] }}')" class="cursor-pointer font-medium text-red-600 hover:text-red-300-500">Remove</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <div class="flex justify-between gap-x-2">
                <x-button white label="Cancel" wire:click="$emit('closeModal')" />
                @if ($actionType == 'add')
                    <x-button positive spinner="addDemand" label="Add Demand" wire:click="addDemand" />
                @elseif ($actionType == 'edit')
                    <x-button positive label="Save Changes" spinner="updateDemand" wire:click="updateDemand" />
                @endif
            </div>
        </div>
    </x-slot>
</x-card>
