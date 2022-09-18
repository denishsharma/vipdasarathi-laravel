<div>
    @if ($task->attachments()->count() > 0)
        <ul role="list" class="border border-gray-200 rounded-md divide-y divide-gray-200">
            @foreach($task->attachments as $attachment)
                <li wire:key="{{ $attachment->id }}" class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                    <div class="w-0 flex-1 flex items-center">
                        <x-icon name="paper-clip" class="w-5 h-5 flex-shrink-0 text-gray-400" />
                        <span class="ml-2 flex-1 w-0 truncate">{{ $attachment->original_filename }}</span>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex gap-5">
                        <a wire:click="downloadAttachment({{ $attachment }})" class="cursor-pointer font-medium text-gray-600 hover:text-gray-300">Download</a>
                        <a wire:click="removeAttachment({{ $attachment }})" class="cursor-pointer font-medium text-red-600 hover:text-red-300">Remove</a>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <div class="border border-dashed border-gray-200 rounded-md p-5 text-center flex flex-col justify-center items-center">
            <h4 class="text-gray-700 font-semibold text-lg">No Attachments</h4>
            <span class="w-8/12 text-sm text-gray-500 mt-2 mb-1">
                There are not any attachments for this task. You can add attachments by clicking the "Manage Attachments" button.
            </span>
        </div>
    @endif
</div>
