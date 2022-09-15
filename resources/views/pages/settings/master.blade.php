@extends('layouts.general', ['title' => 'Settings', 'activeNav' => 'setting'])

@section('attached-navbar')
    <x-navigation.attached-navbar>
        <div>
            <x-navigation.breadcrumb>
                <x-navigation.breadcrumb.breadcrumb-item :start="true" icon="home" type="link" :href="route('home')" label="Home" />
                <x-navigation.breadcrumb.breadcrumb-item :href="route('settings.index')" label="Settings" />
                @yield('breadcrumbs')
            </x-navigation.breadcrumb>
        </div>
        <div>
            <div class="flex justify-end gap-2">
                @yield('setting-quick-actions')
            </div>
        </div>
    </x-navigation.attached-navbar>
@endsection

@section('content')
    <x-layout.sidebar-main>
        <x-slot:sidebar>
            <x-navigation.sidebar-wrapper>
                <x-navigation.sidebar.sidebar-item icon="cog" label="General" :active="request()->routeIs('settings.index')" />
                <x-navigation.sidebar.sidebar-group label="Manage">
                    <x-navigation.sidebar.sidebar-item icon="office-building" label="Organizations" :href="route('settings.organization.index')" :active="request()->routeIs('settings.organization.index')" />
                    <x-navigation.sidebar.sidebar-item icon="user" label="Users" :href="route('settings.user.index')" :active="request()->routeIs('settings.user.index')" />
                </x-navigation.sidebar.sidebar-group>
                <x-navigation.sidebar.sidebar-group label="Master">
                    <x-navigation.sidebar.sidebar-item icon="collection" label="Disaster Types" :href="route('settings.disaster-type.index')" :active="request()->routeIs('settings.disaster-type.index')" />
                    <x-navigation.sidebar.sidebar-item icon="collection" label="Team Types" :href="route('settings.team-type.index')" :active="request()->routeIs('settings.team-type.index')" />
                </x-navigation.sidebar.sidebar-group>
            </x-navigation.sidebar-wrapper>
        </x-slot:sidebar>

        @yield('setting-content')
    </x-layout.sidebar-main>
@endsection
