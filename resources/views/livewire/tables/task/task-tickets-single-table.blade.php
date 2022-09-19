<div class="grid grid-cols-1">
    @if (count($tickets) > 0 or !$headless)
        <div class="grid grid-cols-1 gap-5">
            @if (!$headless)
                <div class="select-none rounded-lg border border-gray-200 px-5">
                    <div class="text-sm font-medium text-center text-gray-500">
                        <ul x-data="{ tab: @entangle('status') }" class="flex flex-wrap -mb-px gap-2 justify-center">
                            <li>
                                <a wire:click="changeTab('all')" :class="tab=='all' ? 'text-primary-600 border-primary-600' : 'border-transparent text-gray-700 hover:text-gray-600 hover:border-gray-300'" class="cursor-pointer inline-block py-2.5 px-3 rounded-t-lg border-b-2">All</a>
                            </li>
                            <li>
                                <a wire:click="changeTab('open')" :class="tab=='open' ? 'text-primary-600 border-primary-600' : 'border-transparent text-gray-700 hover:text-gray-600 hover:border-gray-300'" class="cursor-pointer inline-block py-2.5 px-3 rounded-t-lg border-b-2">Open</a>
                            </li>
                            <li>
                                <a wire:click="changeTab('closed')" :class="tab=='closed' ? 'text-primary-600 border-primary-600' : 'border-transparent text-gray-700 hover:text-gray-600 hover:border-gray-300'" class="cursor-pointer inline-block py-2.5 px-3 rounded-t-lg border-b-2">Closed</a>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif

            <div class="flex-auto h-fit overflow-x-auto border border-gray-200 rounded-lg soft-scrollbar">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 table-auto">
                    <thead class="text-xs font-normal text-gray-500 uppercase bg-stone-100">
                    <tr>
                        <th scope="col" class="py-3 px-5">Subject</th>
                        <th scope="col" class="py-3 px-5">Files</th>
                        <th scope="col" class="py-3 px-5">Issued by</th>
                        <th scope="col" class="py-3 px-5">Status</th>
                        <th scope="col" class="py-3 px-5">Task</th>
                        <th scope="col" class="py-3 px-5">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y">
                    @foreach($tickets as $ticket)
                        <tr class="bg-white dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="py-4 px-5">{{ \Str::limit($ticket->subject, 50) }}</td>
                            <td class="py-4 px-5">{{ $ticket->attachments()->count() }}</td>
                            <td class="py-4 px-5">{{ $ticket->user->full_name() }}</td>
                            <td class="py-4 px-5">{{ $ticket->status() }}</td>
                            <td class="py-4 px-5">
                                @if ($ticket->has_task())
                                    <a href="{{ route('task.view.overview', ['slug' => $ticket->task->slug]) }}" class="font-medium text-secondary-600 dark:text-secondary-400 hover:underline">
                                        View Task
                                    </a>
                                @else
                                    <span class="text-gray-400">No task</span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-right flex items-center justify-start gap-3">
                                <a @click="Livewire.emit('openModal', 'modals.edit-ticket-details', {{ json_encode(['actionType' => 'view', 'ticket' => $ticket]) }})" class="cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>
                                @if ($ticket->status == 'open')
                                    <a @click="Livewire.emit('openModal', 'modals.edit-ticket-details', {{ json_encode(['actionType' => 'task', 'ticket' => $ticket]) }})" class="cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        Create Task
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            @if (!$headless and count($tickets) === 0)
                <div class="border border-dashed border-gray-200 -mt-3 rounded-md p-5 text-center flex flex-col justify-center items-center">
                    <h4 class="text-gray-700 font-semibold text-lg">No Tickets</h4>
                    <span class="w-8/12 text-sm text-gray-500 mt-2 mb-1">
                        There are no tickets associated with this task. You can add tickets to this task by clicking "Add Ticket" button.
                    </span>
                </div>
            @endif
        </div>
    @else
        @if ($headless)
            <div class="border border-dashed border-gray-200 rounded-md p-5 text-center flex flex-col justify-center items-center">
                <h4 class="text-gray-700 font-semibold text-lg">No Tickets</h4>
                <span class="w-8/12 text-sm text-gray-500 mt-2 mb-1">
                There are no tickets associated with this task. You can add tickets to this task by clicking "Add Ticket" button.
            </span>
            </div>
        @endif
    @endif
</div>
