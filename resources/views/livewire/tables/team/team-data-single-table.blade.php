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

    <div class="grid grid-cols-1 gap-2 mt-3">
        <div class="select-none rounded-lg border border-gray-200 px-5 mt-5">
            <div class="text-sm font-medium text-center text-gray-500">
                <ul x-data="{ tab: @entangle('currentTab') }" class="flex flex-wrap -mb-px gap-2 justify-center">
                    <li>
                        <a wire:click="changeTab('members')" :class="tab=='members' ? 'text-primary-600 border-primary-600' : 'border-transparent text-gray-700 hover:text-gray-600 hover:border-gray-300'" class="cursor-pointer inline-block py-2.5 px-3 rounded-t-lg border-b-2">Members</a>
                    </li>
                    <li>
                        <a wire:click="changeTab('active-tasks')" :class="tab=='active-tasks' ? 'text-primary-600 border-primary-600' : 'border-transparent text-gray-700 hover:text-gray-600 hover:border-gray-300'" class="cursor-pointer inline-block py-2.5 px-3 rounded-t-lg border-b-2">
                            Active Tasks
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        @if ($currentTab == 'members')
            <livewire:tables.team.team-members-signle-table :team="$team" />
        @elseif ($currentTab == 'active-tasks')
            <livewire:tables.team.team-tasks-single-table :team="$team" status="active" />
        @endif
    </div>
</div>
