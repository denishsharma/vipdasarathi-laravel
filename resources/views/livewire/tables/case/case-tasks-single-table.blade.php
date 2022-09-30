<div class="grid grid-cols-1 gap-5">
    @if(!$headerLess)
        <div class="select-none rounded-lg border border-gray-200 px-5">
            <div class="text-sm font-medium text-center text-gray-500">
                <ul x-data="{ tab: @entangle('currentTab') }" class="flex flex-wrap -mb-px gap-2 justify-center">
                    <li>
                        <a wire:click="changeTab('all')" :class="tab=='all' ? 'text-primary-600 border-primary-600' : 'border-transparent text-gray-700 hover:text-gray-600 hover:border-gray-300'" class="cursor-pointer inline-block py-2.5 px-3 rounded-t-lg border-b-2">All</a>
                    </li>
                    <li>
                        <a wire:click="changeTab('active')" :class="tab=='active' ? 'text-primary-600 border-primary-600' : 'border-transparent text-gray-700 hover:text-gray-600 hover:border-gray-300'" class="cursor-pointer inline-block py-2.5 px-3 rounded-t-lg border-b-2" aria-current="page">Active</a>
                    </li>
                    <li>
                        <a wire:click="changeTab('completed')" :class="tab=='completed' ? 'text-primary-600 border-primary-600' : 'border-transparent text-gray-700 hover:text-gray-600 hover:border-gray-300'" class="cursor-pointer inline-block py-2.5 px-3 rounded-t-lg border-b-2" aria-current="page">Completed</a>
                    </li>
                    <li>
                        <a wire:click="changeTab('archived')" :class="tab=='archived' ? 'text-primary-600 border-primary-600' : 'border-transparent text-gray-700 hover:text-gray-600 hover:border-gray-300'" class="cursor-pointer inline-block py-2.5 px-3 rounded-t-lg border-b-2" aria-current="page">Archived</a>
                    </li>
                </ul>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-4 @if($headerLess) gap-2 @else gap-5 @endif">
        <div class="border border-gray-200 rounded-lg overflow-hidden h-fit">
            <ul class="divide-y divide-gray-200 w-full h-fit">
                <li wire:click="changeCategory('all')" class="{{ $currentCategory === 'all' ? 'active-button-group-item' : 'is-button-group-item' }}">
                    <x-icon name="database" class="w-4.5 h-4.5" />
                    <span class="text-sm text-gray-700">All Categories</span>
                </li>
                <li wire:click="changeCategory('general')" class="{{ $currentCategory === 'general' ? 'active-button-group-item' : 'is-button-group-item' }}">
                    <x-icon name="collection" class="w-4.5 h-4.5" />
                    <span class="text-sm text-gray-700">General Tasks</span>
                </li>
                <li wire:click="changeCategory('demands')" class="{{ $currentCategory === 'demands' ? 'active-button-group-item' : 'is-button-group-item' }}">
                    <x-icon name="receipt-refund" class="w-4.5 h-4.5" />
                    <span class="text-sm text-gray-700">Demand of Resources</span>
                </li>
                <li wire:click="changeCategory('tickets')" class="{{ $currentCategory === 'tickets' ? 'active-button-group-item' : 'is-button-group-item' }}">
                    <x-icon name="ticket" class="w-4.5 h-4.5" />
                    <span class="text-sm text-gray-700">Tickets & Issues</span>
                </li>
            </ul>
        </div>

        @if(!$headerLess or count($tasks) > 0)
            <div class="col-span-3 flex-auto h-fit overflow-x-auto border border-gray-200 rounded-lg soft-scrollbar">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 table-auto">
                    @if(!$headerLess)
                        <caption class="px-5 py-3 text-lg font-semibold text-left text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                            {{ $heading }}
                            <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400 mb-1">{{ $description }}</p>
                        </caption>
                    @endif
                    <thead class="text-xs font-normal text-gray-500 uppercase bg-stone-100">
                    <tr>
                        <th scope="col" class="py-3 px-5">Subject</th>
                        <th scope="col" class="py-3 px-5">Status</th>
                        <th scope="col" class="py-3 px-5">Teams</th>
                        <th scope="col" class="py-3 px-5">Priority</th>
                        <th scope="col" class="py-3 px-5">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y">
                    @foreach($tasks as $task)
                        <tr class="bg-white dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="py-2 px-5 text-gray-900 dark:text-white">
                                <div class="grid grid-rows-2 grid-cols-1 gap-0.4">
                                    <h4 class="text-sm font-medium text-gray-700">{{ Str::limit($task->subject, 20) }}</h4>
                                    <span class="text-xs font-regular text-gray-500">{{ Str::limit($task->task_type->name, 12) }}</span>
                                </div>
                            </td>
                            <td class="py-2 px-5 text-gray-900 dark:text-white">
                                <div class="grid grid-rows-2 grid-cols-1 gap-0.4">
                                    <h4 class="text-sm font-medium text-gray-700">{{ $task->status() }}</h4>
                                    <span class="text-xs font-regular text-gray-500">{{ Str::limit($task->task_category(), 12) }}</span>
                                </div>
                            </td>
                            <td class="py-2 px-5 text-gray-900 dark:text-white">
                                <div class="grid grid-rows-2 grid-cols-1 gap-0.4">
                                    <h4 class="text-sm font-medium text-gray-700">{{ $task->teams()->count() }}
                                        <a href="#" class="font-medium text-secondary-600 dark:text-secondary-400 hover:underline">(View)</a>
                                    </h4>
                                    <a href="#" class="text-xs font-regular text-secondary-600 dark:text-secondary-400 hover:underline">
                                        View {{ $task->attachments()->count() }} files
                                    </a>
                                </div>
                            </td>
                            <td class="py-4 px-5"> {{ $task->priority() }}</td>
                            <td class="py-4 px-5 text-right flex items-center justify-start gap-3">
                                <a href="{{ route('task.view.overview', ['slug' => $task->slug]) }}" class="cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>

                                @if ($task->status !== 'archived')
                                    <a wire:click="openEditModal({{ $task }})" class="cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                    @if ($task->status === 'active')
                                        <a wire:click="openCompleteTaskModal({{ $task }})" class="cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">Completed</a>
                                    @elseif ($task->status === 'completed')
                                        <a wire:click="openDeleteModal({{ $task }})" class="cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</a>
                                    @endif
                                @endif

                                @if ($task->status === 'archived')
                                    <a wire:click="openRestoreModal({{ $task }})" class="cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">Restore</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        @if($headerLess and count($tasks) === 0)
            <div class="col-span-3 flex-auto h-fit border border-gray-200 rounded-lg px-7 py-5 border-dashed">
                <div class="flex flex-col items-center justify-center text-center">
                    <h4 class="text-gray-700 font-semibold text-lg">No Active Tasks</h4>
                    <span class="w-8/12 text-sm text-gray-500 mt-2 mb-1">
                        This case dont have any active tasks. You can create a new task by clicking the "Add Task" button.
                    </span>
                </div>
            </div>
        @endif
    </div>
</div>
