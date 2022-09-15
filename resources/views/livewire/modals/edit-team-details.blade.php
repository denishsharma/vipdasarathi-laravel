<x-card>
    <x-slot name="header">
        <div class="px-4 py-2.5 flex justify-between items-center border-b dark:border-0 ">
            <h3 class="font-medium whitespace-normal text-md text-secondary-700 dark:text-secondary-400">
                @if ($actionType=='add')
                    Add Team
                @elseif ($actionType=='edit')
                    Edit Team Details
                @elseif ($actionType=='manage-members')
                    Manage Members
                @endif
            </h3>
            <button class="focus:outline-none p-1 focus:ring-2 focus:ring-secondary-200 rounded-full text-secondary-300" wire:click="$emit('closeModal')" tabindex="-1">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </x-slot>
    <div class="grid grid-cols-2 gap-4 soft-scrollbar">
        <x-errors only="slug" class="col-span-1" title="Some problem occurred while submitting" />

        @if ($actionType !== 'manage-members')
            <x-input label="Team Name" placeholder="Enter team name" wire:model="name" />
            <x-select
                label="Team Type"
                placeholder="Select type of team"
                :async-data="route('api.team-type.all')"
                option-label="name"
                option-value="slug"
                wire:model="teamType" />

            <div class="col-span-2">
                <x-textarea label="Description" placeholder="Write something about type..." wire:model="description" />
            </div>
        @endif

        <div class="col-span-1 sm:col-span-2 @if($actionType !== 'manage-members') mt-2 @endif">
            @if($actionType !== 'manage-members')
                <h4 class="block text-md font-semibold text-gray-700 mb-2.2">Manage Members</h4>
            @endif
            <div class="flex justify-between gap-4 mb-2.5">
                <x-select
                    placeholder="Select users to add"
                    :async-data="route('api.user.all')"
                    option-label="name"
                    option-description="email"
                    option-value="slug"
                    hide-empty-message
                    multiselect
                    wire:model="members"
                    class="flex-auto" />
            </div>
            @if (count($members) > 0)
                <div class="">
                    <ul role="list" class="overflow-y-auto soft-scrollbar max-h-40 border border-gray-200 rounded-md divide-y divide-gray-200">
                        @foreach($users as $user)
                            <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                <div class="w-0 flex-1 flex items-center">
                                    <x-icon name="user" class="w-5 h-5 flex-shrink-0 text-gray-400" />
                                    <span class="ml-2 flex-1 w-0 truncate"><span class="font-medium">{{ $user->first_name . ' ' . $user->last_name }}</span> <span class="text-gray-400">({{ $user->email }})</span></span>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <span>{{ $user->organization->name }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <div class="flex justify-between gap-x-2">
                <x-button white label="Cancel" wire:click="$emit('closeModal')" />
                @if ($actionType == 'add')
                    <x-button positive spinner="addTeam" label="Add Team" wire:click="addTeam" />
                @elseif ($actionType == 'edit')
                    <x-button positive label="Save Changes" spinner="updateTeam" wire:click="updateTeam" />
                @elseif ($actionType == 'manage-members')
                    <x-button positive label="Save Changes" spinner="updateTeamMembers" wire:click="updateTeamMembers" />
                @endif
            </div>
        </div>
    </x-slot>
</x-card>
