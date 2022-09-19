<x-card>
    <x-slot name="header">
        <div class="px-4 py-2.5 flex justify-between items-center border-b dark:border-0 ">
            <h3 class="font-medium whitespace-normal text-md text-secondary-700 dark:text-secondary-400">
                @if ($actionType=='add')
                    Add Ticket
                @elseif ($actionType=='edit')
                    Edit Ticket Details
                @elseif ($actionType=='view')
                    View Ticket Details
                @elseif ($actionType=='task')
                    Create task for this ticket
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
            <div class="col-span-2 grid gap-4">
                <x-input label="Ticket Subject" placeholder="Enter ticker subject or title" wire:model="subject" />

                <x-select
                    label="Issued By"
                    placeholder="Select user who issued this ticket"
                    :async-data="route('api.user.all')"
                    option-label="name"
                    option-description="email"
                    option-value="slug"
                    hide-empty-message
                    :clearable="false"
                    wire:model="issuedBy" />

                <x-textarea label="Description" placeholder="Describe your issue..." wire:model="description" />
            </div>
        @endif

        @if($actionType === 'view' or $actionType === 'task')
            <div class="col-span-2 grid gap-5">
                <div>
                    <div class="text-xs uppercase font-medium text-gray-500 mb-1">Subject</div>
                    <div class="text-gray-800 font-semibold text-sm">{{ $ticket->subject }}</div>
                </div>
                <div>
                    <div class="text-xs uppercase font-medium text-gray-500 mb-1">Description</div>
                    <div class="text-sm text-gray-700">{{ $ticket->description }}</div>
                </div>

                @if($ticket->status !== 'closed')
                    @if($actionType !== 'task')
                        <x-select
                            label="Status"
                            Placeholder="Select Status"
                            :options="[
                                ['name' => 'Open', 'value' => 'open'],
                                ['name' => 'Closed', 'value' => 'closed'],
                            ]"
                            option-label="name"
                            option-value="value"
                            :clearable="false"
                            wire:model="status" />
                    @endif
                @endif
            </div>
        @endif

        @if($actionType !== 'task')
            @if(($actionType === 'view' and count($oldAttachments) > 0) or ($actionType === 'edit' or $actionType === 'add'))
                <div class="col-span-1 sm:col-span-2 mt-2">
                    <h4 class="block text-md font-semibold text-gray-700 mb-2.2">Attachments</h4>
                    @if ($actionType === 'add' or $actionType === 'edit')
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
                    @endif

                    @if (count($attachments) > 0 or count($oldAttachments) > 0)
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

                                @if (count($oldAttachments) > 0)
                                    @foreach($oldAttachments as $attachment)
                                        <li wire:key="{{ $attachment->id }}" class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                            <div class="w-0 flex-1 flex items-center">
                                                <x-icon name="paper-clip" class="w-5 h-5 flex-shrink-0 text-gray-400" />
                                                <span class="ml-2 flex-1 w-0 truncate">{{ $attachment->original_filename }}</span>
                                            </div>
                                            <div class="ml-4 flex-shrink-0">
                                                @if($actionType === 'edit')
                                                    <a wire:click="removeAttachment({{ $attachment }})" class="cursor-pointer font-medium text-red-600 hover:text-red-300-500">Remove</a>
                                                @endif

                                                @if($actionType === 'view')
                                                    <a wire:click="downloadAttachment({{ $attachment }})" class="cursor-pointer font-medium text-gray-600 hover:text-gray-300">Download</a>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    @endif
                </div>
            @endif
        @endif
    </div>

    <x-slot name="footer">
        <div class="flex justify-between gap-x-4">
            <div>
                @if ($actionType=='view' and $ticket->status !== 'closed')
                    <x-button positive label="Update Status" spinner="updateTicketStatus" wire:click="updateTicketStatus" />
                @endif
            </div>
            <div class="flex justify-between gap-x-2">
                <x-button white label="Cancel" wire:click="$emit('closeModal')" />
                @if ($actionType == 'add')
                    <x-button positive spinner="addTicket" label="Add Ticket" wire:click="addTicket" />
                @elseif ($actionType == 'edit')
                    <x-button positive label="Save Changes" spinner="updateTicket" wire:click="updateTicket" />
                @elseif ( $actionType == 'view' )
                    <x-button primary label="Okay" wire:click="$emit('closeModal')" />
                @elseif ($actionType == 'task')
                    <x-button positive label="Create Task" spinner="createTicketTask" wire:click="createTicketTask" />
                @endif
            </div>
        </div>
    </x-slot>
</x-card>
