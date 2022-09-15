<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 table-auto">
    <caption class="px-5 py-3 text-lg font-semibold text-left text-gray-900 bg-white dark:text-white dark:bg-gray-800">
        Manage Disaster Types
        <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400 mb-1">{{ $description }}</p>
    </caption>
    <thead class="text-xs font-normal text-gray-500 uppercase bg-stone-100">
    <tr>
        <th scope="col" class="py-3 px-5">Name</th>
        <th scope="col" class="py-3 px-5">Cases</th>
        <th scope="col" class="py-3 px-5">Actions</th>
    </tr>
    </thead>
    <tbody class="divide-y">
    @foreach($disasterTypes as $disasterType)
        <tr class="bg-white dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td class="py-4 px-5">{{ $disasterType->name }}</td>
            <td class="py-4 px-5">
                {{ $disasterType->cases()->count() }}
                <a href="#" class="font-medium text-secondary-600 dark:text-secondary-400 hover:underline">(View)</a>
            </td>
            <td class="py-4 px-5 text-right flex items-center justify-start gap-3">
                @if ($currentTab === 'archived')
                    <a wire:click="openRestoreModal({{ $disasterType }})" class="cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">Restore</a>
                @else
                    <a wire:click="openEditModal({{ $disasterType }})" class="cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    <a wire:click="openDeleteModal({{ $disasterType }})" class="cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
