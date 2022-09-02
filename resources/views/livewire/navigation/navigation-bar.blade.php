<nav class="bg-gray-50">
    <div class="mx-auto px-2 sm:px-6 lg:px-20">
        <div class="relative flex items-center justify-between h-16">
            <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                <div class="flex-shrink-0 flex items-center mr-4">
                    <img class="block h-9 w-auto" src="{{ asset('images/logo-vipdasarathi.png') }}" alt="Workflow">
                </div>
                <div class="hidden sm:block sm:ml-6">
                    <div class="flex space-x-2" x-data="{ active: @entangle('active') }">
                        <a href="#" :class="active === 'home' ? 'active-navbar-button' : 'is-navbar-button'">Home</a>
                        <a href="#" :class="active === 'case' ? 'active-navbar-button' : 'is-navbar-button'">Cases</a>
                        <a href="#" :class="active === 'relief' ? 'active-navbar-button' : 'is-navbar-button'">Relief
                                                                                                               Centres</a>
                        <a href="#" :class="active === 'team' ? 'active-navbar-button' : 'is-navbar-button'">Teams</a>
                        <a href="#" :class="active === 'volunteer' ? 'active-navbar-button' : 'is-navbar-button'">Volunteers</a>
                        <a href="#" :class="active === 'ticket' ? 'active-navbar-button' : 'is-navbar-button'">Tickets</a>
                        <a href="#" :class="active === 'setting' ? 'active-navbar-button' : 'is-navbar-button'">Settings</a>
                    </div>
                </div>
            </div>
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                <div class="flex gap-2">
                    <x-button.circle flat icon="search" />
                    <x-button.circle flat icon="bell" />
                    <x-button.circle flat icon="home" />
                </div>

                <!-- Profile dropdown -->
                <div class="ml-4 relative">
                    <div>
                        <x-dropdown>
                            <x-slot name="trigger">
                                <div
                                    class="flex items-center py-2 px-2 hover:border-gray-200 border-transparent transition-colors border rounded-lg hover:bg-white text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="pr-3">
                                        <div class="text-xs text-right font-semibold">John Doe</div>
                                        <div class="font-normal text-right text-xs text-gray-500">johndoe@gmail.com
                                        </div>
                                    </div>
                                    <img class="w-8 h-8 rounded-full border border-gray-200"
                                         src="https://ui-avatars.com/api/?name=John+Doe" alt="Jese image">
                                </div>
                            </x-slot>

                            <x-dropdown.header label="Settings">
                                <x-dropdown.item label="Preferences" />
                                <x-dropdown.item label="My Profile" />
                            </x-dropdown.header>

                            <x-dropdown.item separator wire:click="logoutUser" label="Logout" />
                        </x-dropdown>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="sm:hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            <a href="#" class="bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium"
               aria-current="page">Dashboard</a>

            <a href="#"
               class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Team</a>

            <a href="#"
               class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Projects</a>

            <a href="#"
               class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Calendar</a>
        </div>
    </div>
</nav>
