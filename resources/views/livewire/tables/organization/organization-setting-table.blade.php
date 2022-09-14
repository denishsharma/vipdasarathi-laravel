<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 table-auto">
    <caption class="px-5 py-3 text-lg font-semibold text-left text-gray-900 bg-white dark:text-white dark:bg-gray-800">
        Manage Organization
        <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400 mb-1">{{ $description }}</p>
    </caption>
    <thead class="text-xs font-normal text-gray-500 uppercase bg-stone-100">
    <tr>
        <th scope="col" class="py-3 px-5">Name</th>
        <th scope="col" class="py-3 px-5">Level</th>
        <th scope="col" class="py-3 px-5">Users</th>
        <th scope="col" class="py-3 px-5">Actions</th>
    </tr>
    </thead>
    <tbody class="divide-y">
    @foreach($organizations as $organization)
        <tr class="bg-white dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td class="py-4 px-5">{{ $organization->name }}</td>
            <td class="py-4 px-5">{{ $organization->level() }}</td>
            <td class="py-4 px-5">
                {{ $organization->users()->count() }}
                <a href="#" class="font-medium text-secondary-600 dark:text-secondary-400 hover:underline">(View)</a>
            </td>
            <td class="py-4 px-5 text-right flex items-center justify-start gap-3">
                @if ($currentTab === 'archived')
                    <a wire:click="openRestoreModal({{ $organization }})" class="cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">Restore</a>
                @else
                    <a wire:click="openEditModal({{ $organization }})" class="cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    <a href="#" class="cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>
                    <a wire:click="openDeleteModal({{ $organization }})" class="cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
