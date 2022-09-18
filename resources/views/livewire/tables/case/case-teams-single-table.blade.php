<div class="grid grid-cols-1">
    <div class="col-span-3 flex-auto h-fit overflow-x-auto border border-gray-200 rounded-lg soft-scrollbar">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 table-auto">
            <caption class="px-5 py-3 text-lg font-semibold text-left text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                Teams Assigned to this Case
                <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400 mb-1">
                    Here you will find all the teams assigned to this case. You can also assign new teams to this case
                    by creating tasks.
                </p>
            </caption>
            <thead class="text-xs font-normal text-gray-500 uppercase bg-stone-100">
            <tr>
                <th scope="col" class="py-3 px-5">Name</th>
                <th scope="col" class="py-3 px-5">Type</th>
                <th scope="col" class="py-3 px-5">Members</th>
                <th scope="col" class="py-3 px-5">Status</th>
                <th scope="col" class="py-3 px-5">Tasks</th>
            </tr>
            </thead>
            <tbody class="divide-y">
            @foreach($teams as $team)
                <tr class="bg-white dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="py-4 px-5">{{ $team->name }}</td>
                    <td class="py-4 px-5">{{ $team->team_type->name }}</td>
                    <td class="py-4 px-5">
                        {{ $team->users()->count() }}
                        <a href="{{ route('team.view.overview', ['slug' => $team->slug]) }}" class="font-medium text-secondary-600 dark:text-secondary-400 hover:underline">(View)</a>
                    </td>
                    <td class="py-4 px-5">{{ $team->status() }}</td>
                    <td class="py-4 px-5">
                        {{ $team->tasks()->count() }}
                        <a href="" class="font-medium text-secondary-600 dark:text-secondary-400 hover:underline">(View)</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
</div>
