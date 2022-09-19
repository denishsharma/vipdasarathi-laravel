<div class="grid grid-cols-1 gap-2">
    @if($task->subject)
        <div class="border border-gray-200 rounded-lg soft-scrollbar px-5 py-3">
            <div class="text-xs uppercase font-medium text-gray-500 mb-1">Subject</div>
            <div class="text-gray-800 font-semibold text-md">{{ $task->subject }}</div>
        </div>
    @endif

    <div class="overflow-x-auto border border-gray-200 rounded-lg soft-scrollbar">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 table-auto">
            <thead class="text-xs font-normal text-gray-500 uppercase bg-stone-100">
            <tr>
                <th scope="col" class="py-3 px-5">Type</th>
                <th scope="col" class="py-3 px-5">Status</th>
                <th scope="col" class="py-3 px-5">Teams</th>
                <th scope="col" class="py-3 px-5">Priority</th>
                <th scope="col" class="py-3 px-5">Category</th>
            </tr>
            </thead>
            <tbody class="divide-y">
            <tr class="bg-whit">
                <td class="py-4 px-5">{{ $task->task_type->name }}</td>
                <td class="py-4 px-5">{{ $task->status() }}</td>
                <td class="py-4 px-5">{{ $task->teams()->count() }}</td>
                <td class="py-4 px-5">{{ $task->priority() }}</td>
                <td class="py-4 px-5">{{ $task->task_category() }}</td>
            </tr>
            </tbody>
        </table>
    </div>

    @if($task->description)
        <div class="border border-gray-200 rounded-lg soft-scrollbar px-5 py-3">
            <div class="text-xs uppercase font-medium text-gray-500 mb-1">Description</div>
            <div class="text-gray-700">{{ $task->description }}</div>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-2 mt-3">
        <div class="select-none rounded-lg border border-gray-200 px-5 mt-5">
            <div class="text-sm font-medium text-center text-gray-500">
                <ul x-data="{ tab: @entangle('currentTab') }" class="flex flex-wrap -mb-px gap-2 justify-center">
                    <li>
                        <a wire:click="changeTab('teams')" :class="tab=='teams' ? 'text-primary-600 border-primary-600' : 'border-transparent text-gray-700 hover:text-gray-600 hover:border-gray-300'" class="cursor-pointer inline-block py-2.5 px-3 rounded-t-lg border-b-2">Teams</a>
                    </li>
                    <li>
                        <a wire:click="changeTab('tickets')" :class="tab=='tickets' ? 'text-primary-600 border-primary-600' : 'border-transparent text-gray-700 hover:text-gray-600 hover:border-gray-300'" class="cursor-pointer inline-block py-2.5 px-3 rounded-t-lg border-b-2">
                            Open Tickets
                        </a>
                    </li>
                    <li>
                        <a wire:click="changeTab('attachments')" :class="tab=='attachments' ? 'text-primary-600 border-primary-600' : 'border-transparent text-gray-700 hover:text-gray-600 hover:border-gray-300'" class="cursor-pointer inline-block py-2.5 px-3 rounded-t-lg border-b-2">Attachments</a>
                    </li>
                </ul>
            </div>
        </div>

        @if ($currentTab == 'teams')
            <livewire:tables.task.task-teams-single-table :task="$task" />
        @elseif ($currentTab == 'tickets')
            <livewire:tables.task.task-tickets-single-table :headless="true" :task="$task" status="open" />
        @elseif($currentTab == 'attachments')
            <livewire:tables.task.task-attachments-single-table :task="$task" />
        @endif
    </div>
</div>
