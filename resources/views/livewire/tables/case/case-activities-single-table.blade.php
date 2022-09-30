<div class="grid grid-cols-1">
    <div class="h-fit border border-gray-200 rounded-lg px-7 py-5 @if(count($activities) > 0) border-dashed @endif ">
        @if (count($activities) > 0)
            <ol class="relative border-l border-gray-200 dark:border-gray-700">
                @foreach($activities as $activity)
                    <li class="@if(!$loop->last) mb-10 @endif ml-6">
                    <span class="flex absolute -left-3 justify-center items-center w-6 h-6 bg-blue-200 rounded-full ring-8 ring-white">
                        <x-icon solid name="annotation" class="h-3 w-3 text-blue-600" />
                    </span>
                        <h3 class="flex items-center mb-1 text-sm font-semibold text-gray-700">{{ $activity->subject }}
                            @if ($loop->first)
                                <span class="bg-blue-100 text-blue-800 text-xs uppercase font-medium mr-2 px-1 py-0.5 rounded ml-3">Latest</span>
                            @endif
                        </h3>
                        <div class="flex gap-2 items-center mb-2 text-sm font-normal leading-none">
                            <span class="text-gray-500">{{ $activity->user->full_name() }}</span>
                            <div class="h-1 w-1 rounded-full bg-gray-200"></div>
                            <span class="block text-gray-400">Updated on {{ \Carbon\Carbon::parse($activity->created_at)->format('h:m:s A @ d M, Y') }}</span>
                        </div>
                        <div class="mb-4 font-normal text-sm text-gray-500">{!! $activity->description !!}</div>
                        @if ($activity->actions)
                            <div class="flex gap-2 mb-4 -mt-1">
                                @foreach($activity->actions as $action)
                                    <x-button xs class="text-sm" href="{{ $action['url'] }}" label="{{ $action['label'] }}" />
                                @endforeach
                            </div>
                        @endif
                        @if ($activity->attachments()->count() > 0)
                            <div>
                                <ul role="list" class="border border-gray-200 rounded-md divide-y divide-gray-200">
                                    @foreach($activity->attachments as $attachment)
                                        <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                            <div class="w-0 flex-1 flex items-center">
                                                <x-icon name="paper-clip" class="w-5 h-5 flex-shrink-0 text-gray-400" />
                                                <span class="ml-2 flex-1 w-0 truncate">{{ $attachment->original_filename }}</span>
                                            </div>
                                            <div class="ml-4 flex-shrink-0">
                                                <a wire:click="downloadAttachment({{ $attachment }})" class="cursor-pointer font-medium text-gray-600 hover:text-gray-300">Download</a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ol>
        @else
            <div class="flex flex-col items-center justify-center text-center">
                <h4 class="text-gray-700 font-semibold text-lg">No Activities Yet!</h4>
                <span class="w-8/12 text-sm text-gray-500 mt-2 mb-1">
                    This case dont have any activities yet.
                </span>
            </div>
        @endif
    </div>

</div>
