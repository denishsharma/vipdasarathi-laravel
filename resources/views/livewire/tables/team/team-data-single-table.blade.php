<div class="grid grid-cols-1 gap-2">
    <div class="overflow-x-auto border border-gray-200 rounded-lg soft-scrollbar">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 table-auto">
            <thead class="text-xs font-normal text-gray-500 uppercase bg-stone-100">
            <tr>
                <th scope="col" class="py-3 px-5">Name</th>
                <th scope="col" class="py-3 px-5">Type</th>
                <th scope="col" class="py-3 px-5">Members</th>
                <th scope="col" class="py-3 px-5">Status</th>
            </tr>
            </thead>
            <tbody class="divide-y">
            <tr class="bg-whit">
                <td class="py-4 px-5">{{ $team->name }}</td>
                <td class="py-4 px-5">{{ $team->team_type->name }}</td>
                <td class="py-4 px-5">{{ $team->users()->count() }}</td>
                <td class="py-4 px-5">{{ $team->status() }}</td>
            </tr>
            </tbody>
        </table>
    </div>

    @if($team->description)
        <div class="border border-gray-200 rounded-lg soft-scrollbar px-5 py-3">
            <div class="text-xs uppercase font-medium text-gray-500 mb-1">Description</div>
            <div class="text-gray-700">{{ $team->description }}</div>
        </div>
    @endif
</div>
