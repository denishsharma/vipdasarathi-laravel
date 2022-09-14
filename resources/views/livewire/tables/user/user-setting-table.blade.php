<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 table-fixed">
    <caption
        class="px-5 py-3 text-lg font-semibold text-left text-gray-900 bg-white dark:text-white dark:bg-gray-800">
        Users
        <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">{{ $description }}</p>
    </caption>
    <thead class="text-xs font-normal text-gray-500 uppercase bg-stone-100">
    <tr>
        <th scope="col" class="py-3 px-6">Name</th>
        <th scope="col" class="py-3 px-6">Contact</th>
        <th scope="col" class="py-3 px-6">Organization</th>
        <th scope="col" class="py-3 px-6">Actions</th>
    </tr>
    </thead>
    <tbody class="divide-y">
    @foreach($users as $user)
        <tr class="bg-white dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td class="py-2 px-6 text-gray-900 dark:text-white">
                <div class="grid grid-rows-2 grid-cols-1 gap-0.4">
                    <h4 class="text-sm font-medium text-gray-700">{{ join(" ", [$user->first_name, $user->last_name ?? '']) }}</h4>
                    <span class="text-xs font-regular text-gray-500">{{ $user->slug }}</span>
                </div>
            </td>

            <td class="py-2 px-6 text-gray-900 dark:text-white">
                <div class="grid grid-rows-2 grid-cols-1 gap-0.4">
                    <h4 class="text-sm font-medium text-gray-700">{{ $user->user_profile->mobile }}</h4>
                    <span class="text-xs font-regular text-gray-500">{{ $user->email }}</span>
                </div>
            </td>

            <td class="py-2 px-6 text-gray-900 dark:text-white">
                <div class="grid grid-rows-2 grid-cols-1 gap-0.4">
                    <h4 class="text-sm font-medium text-gray-700">{{ $user->organization->name }}</h4>
                    <span class="text-xs font-regular text-gray-500">
                        <a href="#" class="font-medium text-primary-600 dark:text-primary-400 hover:underline">View</a>
                    </span>
                </div>
            </td>

            <td class="py-4 px-6 text-right flex items-center justify-start gap-3">
                @if ($currentTab === 'archived')
                    <a wire:click="openRestoreModal('{{ $user->first_name }}', '{{ $user->last_name }}', '{{ $user->slug }}')" class="cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">Restore</a>
                @else
                    <a wire:click="openEditModal({{ $user }})" class="cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>
                    <a wire:click="openDeleteModal({{ $user }})" class="cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
