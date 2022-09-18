@if(count($tasks) > 0)
    <div class="overflow-x-auto border border-gray-200 rounded-lg soft-scrollbar h-fit">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 table-auto">
            <thead class="text-xs font-normal text-gray-500 uppercase bg-stone-100">
            <tr>
                <th scope="col" class="py-3 px-5">Subject</th>
                <th scope="col" class="py-3 px-5">Status</th>
                <th scope="col" class="py-3 px-5">Attachments</th>
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
                            <h4 class="text-sm font-medium text-gray-700">{{ $task->attachments()->count() }}</h4>
                            <a href="{{ route('task.view.attachments', ['slug' => $task->slug]) }}" class="text-xs font-regular text-secondary-600 dark:text-secondary-400 hover:underline">
                                View Attachments
                            </a>
                        </div>
                    </td>
                    <td class="py-4 px-5"> {{ $task->priority() }}</td>
                    <td class="py-4 px-5 text-right flex items-center justify-start gap-3">
                        <a href="{{ route('task.view.overview', ['slug' => $task->slug]) }}" class="cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="h-fit border border-dashed border-gray-200 rounded-md p-5 text-center flex flex-col justify-center items-center">
        <h4 class="text-gray-700 font-semibold text-lg">No Tasks Yet!</h4>
        <span class="w-8/12 text-sm text-gray-500 mt-2 mb-1">
            There are not any tasks for this team. You can assign tasks through the cases.
        </span>
    </div>
@endif
