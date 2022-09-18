@if($team->users()->count() > 0)
    <div class="h-fit overflow-x-auto border border-gray-200 rounded-lg soft-scrollbar">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 table-fixed">
            <thead class="text-xs font-normal text-gray-500 uppercase bg-stone-100">
            <tr>
                <th scope="col" class="py-3 px-6">Name</th>
                <th scope="col" class="py-3 px-6">Contact</th>
                <th scope="col" class="py-3 px-6">Organization</th>
            </tr>
            </thead>
            <tbody class="divide-y">
            @foreach($team->users as $user)
                <tr class="bg-white dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="py-2 px-6 text-gray-900 dark:text-white">
                        <div class="grid grid-rows-2 grid-cols-1 gap-0.4">
                            <h4 class="text-sm font-medium text-gray-700">{{ join(" ", [$user->first_name, $user->last_name ?? '']) }}</h4>
                            <span class="text-xs font-regular text-gray-500">{{ $user->user_type() }}</span>
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
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="h-fit border border-dashed border-gray-200 rounded-md p-5 text-center flex flex-col justify-center items-center">
        <h4 class="text-gray-700 font-semibold text-lg">No Members</h4>
        <span class="w-8/12 text-sm text-gray-500 mt-2 mb-1">
            There are no members in this team. You can add members by clicking on "Manage Members" button.
        </span>
    </div>
@endif
