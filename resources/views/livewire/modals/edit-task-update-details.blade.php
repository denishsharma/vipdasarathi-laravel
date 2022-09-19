<x-card>
    <x-slot name="header">
        <div class="px-4 py-2.5 flex justify-between items-center border-b dark:border-0 ">
            <h3 class="font-medium whitespace-normal text-md text-secondary-700 dark:text-secondary-400">
                @if ($actionType=='add')
                    Add Task Update
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
        <div class="col-span-2">
            <x-input label="Update Subject" placeholder="Enter task update subject or title" wire:model="subject" />
        </div>

        <x-select
            label="Update By"
            placeholder="Select update from"
            :async-data="route('api.user.all')"
            option-label="name"
            option-description="email"
            option-value="slug"
            hide-empty-message
            :clearable="false"
            wire:model="updateBy" />

        <x-select
            label="Activity Type"
            placeholder="Select type of activity"
            :async-data="route('api.activity-type.all')"
            option-label="name"
            option-value="slug"
            wire:model="activityType" />

        <div class="col-span-2">
            <x-textarea label="Description" placeholder="Write something about type..." wire:model="description" />
        </div>

        <div class="col-span-1 sm:col-span-2 mt-2">
            <h4 class="block text-md font-semibold text-gray-700 mb-2.2">Attachments</h4>
            <div class="grid grid-cols-1 mb-2.5">
                <x-input type="file" multiple wire:model="attachments" placeholder="Select files to upload">
                    @if (count($attachments) > 0)
                        <x-slot name="append">
                            <div class="absolute inset-y-0 right-0 flex items-center p-0.5">
                                <x-button wire:click="clearAttachments" flat squared icon="trash" label="Clear Files" class="h-full rounded-r-md" />
                            </div>
                        </x-slot>
                    @endif
                </x-input>
            </div>

            @if (count($attachments) > 0)
                <div class="">
                    <ul role="list" class="border border-gray-200 rounded-md divide-y divide-gray-200">
                        @foreach($attachments as $attachment)
                            <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                <div class="w-0 flex-1 flex items-center">
                                    <x-icon name="paper-clip" class="w-5 h-5 flex-shrink-0 text-gray-400" />
                                    <span class="ml-2 flex-1 w-0 truncate">{{ $attachment->getClientOriginalName() }}</span>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <span class="font-medium text-gray-500">{{ \App\Helpers\Utilities::formatBytes($attachment->getSize()) }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <div class="flex justify-between gap-x-2">
                <x-button white label="Cancel" wire:click="$emit('closeModal')" />
                @if ($actionType == 'add')
                    <x-button positive spinner="addTaskUpdate" label="Add Task Update" wire:click="addTaskUpdate" />
                @endif
            </div>
        </div>
    </x-slot>
</x-card>
