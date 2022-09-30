<div class="grid grid-cols-1 gap-2">
    @if($case->title)
        <div class="border border-gray-200 rounded-lg soft-scrollbar px-5 py-3">
            <div class="text-xs uppercase font-medium text-gray-500 mb-1">Title</div>
            <div class="text-gray-800 font-semibold text-md">{{ $case->title }}</div>
        </div>
    @endif

    <div class="overflow-x-auto border border-gray-200 rounded-lg soft-scrollbar">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 table-auto">
            <thead class="text-xs font-normal text-gray-500 uppercase bg-stone-100">
            <tr>
                <th scope="col" class="py-3 px-5">Happened At</th>
                <th scope="col" class="py-3 px-5">Tasks</th>
                <th scope="col" class="py-3 px-5">Teams</th>
                <th scope="col" class="py-3 px-5">Tickets</th>
                <th scope="col" class="py-3 px-5">Demands</th>
                <th scope="col" class="py-3 px-5">Priority</th>
                <th scope="col" class="py-3 px-5">Disaster Type</th>
                <th scope="col" class="py-3 px-5">Status</th>
            </tr>
            </thead>
            <tbody class="divide-y">
            <tr class="bg-whit">
                <td class="py-2 px-5 text-gray-900 dark:text-white">
                    <div class="grid grid-rows-2 grid-cols-1 gap-0.4">
                        <h4 class="text-sm font-medium text-gray-700">{{ \Carbon\Carbon::parse($case->happened_at)->format('d M, Y') }}</h4>
                        <span class="text-xs font-regular text-gray-500">{{ \Carbon\Carbon::parse($case->happened_at)->format('h:m A') }}</span>
                    </div>
                </td>
                <td class="py-2 px-5 text-gray-900 dark:text-white">
                    <div class="grid grid-rows-2 grid-cols-1 gap-0.4">
                        <h4 class="text-sm font-medium text-gray-700">{{ $case->tasks()->count() }}</h4>
                        <a href="{{ route('case.view.tasks', ['slug' => $case->slug]) }}" class="text-xs font-regular text-secondary-600 dark:text-secondary-400 hover:underline">
                            View
                        </a>
                    </div>
                </td>
                <td class="py-2 px-5 text-gray-900 dark:text-white">
                    <div class="grid grid-rows-2 grid-cols-1 gap-0.4">
                        <h4 class="text-sm font-medium text-gray-700">{{ $case->teams()->count() }}</h4>
                        <a href="{{ route('case.view.teams', ['slug' => $case->slug]) }}" class="text-xs font-regular text-secondary-600 dark:text-secondary-400 hover:underline">
                            View
                        </a>
                    </div>
                </td>
                <td class="py-2 px-5 text-gray-900 dark:text-white">
                    <div class="grid grid-rows-2 grid-cols-1 gap-0.4">
                        <h4 class="text-sm font-medium text-gray-700">{{ $case->has_many_tickets()->count() }}</h4>
                        <a href="{{ route('case.view.tickets', ['slug' => $case->slug]) }}" class="text-xs font-regular text-secondary-600 dark:text-secondary-400 hover:underline">
                            View
                        </a>
                    </div>
                </td>
                <td class="py-4 px-5">{{ '0' }}</td>
                <td class="py-4 px-5">{{ $case->priority() }}</td>
                <td class="py-4 px-5">{{ $case->disaster_type->name }}</td>
                <td class="py-4 px-5">{{ $case->status() }}</td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="grid grid-cols-6 gap-2">
        <div class="border border-gray-200 rounded-lg px-5 py-3">
            <div class="text-xs uppercase font-medium text-gray-500 mb-1">Total Victims</div>
            <div class="text-gray-800 font-semibold text-xl">{{ $case->disaster_case_metadata->get_casualties()['total'] }}</div>
        </div>
        <div class="border border-gray-200 rounded-lg px-5 py-3">
            <div class="text-xs uppercase font-medium text-gray-500 mb-1">Deaths</div>
            <div class="text-gray-800 font-semibold text-xl">{{ $case->disaster_case_metadata->get_casualties()['deaths'] }}</div>
        </div>
        <div class="border border-gray-200 rounded-lg px-5 py-3">
            <div class="text-xs uppercase font-medium text-gray-500 mb-1">Rescued</div>
            <div class="text-gray-800 font-semibold text-xl">{{ $case->disaster_case_metadata->get_casualties()['rescued'] }}</div>
        </div>
        <div class="border border-gray-200 rounded-lg px-5 py-3">
            <div class="text-xs uppercase font-medium text-gray-500 mb-1">Injured</div>
            <div class="text-gray-800 font-semibold text-xl">{{ $case->disaster_case_metadata->get_casualties()['injured'] }}</div>
        </div>
        <div class="border border-gray-200 rounded-lg px-5 py-3">
            <div class="text-xs uppercase font-medium text-gray-500 mb-1">Missing</div>
            <div class="text-gray-800 font-semibold text-xl">{{ $case->disaster_case_metadata->get_casualties()['missing'] }}</div>
        </div>
        <div class="border border-gray-200 rounded-lg px-5 py-3">
            <div class="text-xs uppercase font-medium text-gray-500 mb-1">Shelters</div>
            <div class="text-gray-800 font-semibold text-xl">290</div>
        </div>
    </div>

    @if($case->description)
        <div class="border border-gray-200 rounded-lg soft-scrollbar px-5 py-3">
            <div class="text-xs uppercase font-medium text-gray-500 mb-1">Description</div>
            <div class="text-gray-700">{{ $case->description }}</div>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-2 mt-3">
        <div class="select-none rounded-lg border border-gray-200 px-5 mt-2">
            <div class="text-sm font-medium text-center text-gray-500">
                <ul x-data="{ tab: @entangle('currentTab') }" class="flex flex-wrap -mb-px gap-2 justify-center">
                    <li>
                        <a wire:click="changeTab('activities')" :class="tab=='activities' ? 'text-primary-600 border-primary-600' : 'border-transparent text-gray-700 hover:text-gray-600 hover:border-gray-300'" class="cursor-pointer inline-block py-2.5 px-3 rounded-t-lg border-b-2">Activity</a>
                    </li>
                    <li>
                        <a wire:click="changeTab('location')" :class="tab=='location' ? 'text-primary-600 border-primary-600' : 'border-transparent text-gray-700 hover:text-gray-600 hover:border-gray-300'" class="cursor-pointer inline-block py-2.5 px-3 rounded-t-lg border-b-2">Location</a>
                    </li>
                    <li>
                        <a wire:click="changeTab('active-tasks')" :class="tab=='active-tasks' ? 'text-primary-600 border-primary-600' : 'border-transparent text-gray-700 hover:text-gray-600 hover:border-gray-300'" class="cursor-pointer inline-block py-2.5 px-3 rounded-t-lg border-b-2">
                            Active Tasks
                        </a>
                    </li>
                    <li>
                        <a wire:click="changeTab('open-tickets')" :class="tab=='open-tickets' ? 'text-primary-600 border-primary-600' : 'border-transparent text-gray-700 hover:text-gray-600 hover:border-gray-300'" class="cursor-pointer inline-block py-2.5 px-3 rounded-t-lg border-b-2">
                            Open Tickets
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        @if ($currentTab == 'activities')
            <livewire:tables.case.case-activities-single-table :case="$case" />
        @elseif ($currentTab == 'location')
            <div class="border border-gray-200 rounded-lg soft-scrollbar px-5 py-3 grid grid-cols-2 gap-5 ">
                <div class="col-span-2">
                    <div class="text-xs uppercase font-medium text-gray-500 mb-1">Address Line</div>
                    <div class="text-gray-700 font-medium text-sm">{{ $case->address->address_line_1 }}</div>
                </div>

                <div>
                    <div class="text-xs uppercase font-medium text-gray-500 mb-1">Zip Code</div>
                    <div class="text-gray-700 font-medium text-sm">{{ $case->address->zipcode }}</div>
                </div>

                <div>
                    <div class="text-xs uppercase font-medium text-gray-500 mb-1">City</div>
                    <div class="text-gray-700 font-medium text-sm">{{ $case->address->city }}</div>
                </div>

                <div>
                    <div class="text-xs uppercase font-medium text-gray-500 mb-1">District</div>
                    <div class="text-gray-700 font-medium text-sm">{{ $case->address->district }}</div>
                </div>

                <div>
                    <div class="text-xs uppercase font-medium text-gray-500 mb-1">State</div>
                    <div class="text-gray-700 font-medium text-sm">{{ ucwords($case->address->state->name) }}</div>
                </div>
            </div>
        @elseif($currentTab == 'active-tasks')
            <livewire:tables.case.case-tasks-single-table :case="$case" current-tab="active" :header-less="true" />
        @elseif($currentTab == 'open-tickets')
            <livewire:tables.case.case-tickets-single-table :case="$case" status="open" :header-less="true" />
        @endif
    </div>
</div>
