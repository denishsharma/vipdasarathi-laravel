<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 table-auto">
    <caption class="px-5 py-3 text-lg font-semibold text-left text-gray-900 bg-white dark:text-white dark:bg-gray-800">
        {{ $heading }}
        <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400 mb-1">{{ $description }}</p>
    </caption>
    <thead class="text-xs font-normal text-gray-500 uppercase bg-stone-100">
    <tr>
        <th scope="col" class="py-3 px-5">Case Title</th>
        <th scope="col" class="py-3 px-5">Happened At</th>
        <th scope="col" class="py-3 px-5">Priority</th>
        <th scope="col" class="py-3 px-5">Location</th>
        <th scope="col" class="py-3 px-5">Disaster Type</th>
        <th scope="col" class="py-3 px-5">Status</th>
        <th scope="col" class="py-3 px-5">Actions</th>
    </tr>
    </thead>
    <tbody class="divide-y">
    @foreach($cases as $case)
        <tr class="bg-white dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td class="py-2 px-5 text-gray-900 dark:text-white">
                <div class="grid grid-rows-2 grid-cols-1 gap-0.4">
                    <h4 class="text-sm font-medium text-gray-700">{{ Str::limit($case->title, 20) }}</h4>
                    <span class="text-xs font-regular text-gray-500">{{ Str::limit($case->slug, 12) }}</span>
                </div>
            </td>
            <td class="py-2 px-5 text-gray-900 dark:text-white">
                <div class="grid grid-rows-2 grid-cols-1 gap-0.4">
                    <h4 class="text-sm font-medium text-gray-700">{{ \Carbon\Carbon::parse($case->happened_at)->format('d M, Y') }}</h4>
                    <span class="text-xs font-regular text-gray-500">{{ \Carbon\Carbon::parse($case->happened_at)->format('h:m A') }}</span>
                </div>
            </td>
            <td class="py-4 px-5">{{ $case->priority() }}</td>
            <td class="py-2 px-5 text-gray-900 dark:text-white">
                <div class="grid grid-rows-2 grid-cols-1 gap-0.4">
                    <h4 class="text-sm font-medium text-gray-700">{{ Str::limit($case->address->district, 20) }}</h4>
                    <span class="text-xs font-regular text-gray-500">{{ Str::limit(ucwords($case->address->state->name), 20) }}</span>
                </div>
            </td>
            <td class="py-4 px-5">{{ $case->disaster_type->name }}</td>
            <td class="py-4 px-5">{{ $case->status() }}</td>
            <td class="py-4 px-5 text-right flex items-center justify-start gap-3">
                <a href="{{ route('case.view.overview', ['slug' => $case->slug]) }}" class="cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>
                @if ($case->status === 'closed')
                    <a wire:click="openRestoreCaseModal({{ $case }})" class="cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">Activate</a>
                @else
                    <a wire:click="openEditModal({{ $case }})" class="cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    <a wire:click="openCloseCaseModal({{ $case }})" class="cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">Close</a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
