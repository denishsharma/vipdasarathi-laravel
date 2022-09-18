@extends('layouts.general', ['title' => 'Team Details'.$title, 'activeNav' => 'team'])

@section('attached-navbar')
    <x-navigation.attached-navbar>
        <div>
            <x-navigation.breadcrumb>
                <x-navigation.breadcrumb.breadcrumb-item :start="true" icon="home" type="link" :href="route('home')" label="Home" />
                <x-navigation.breadcrumb.breadcrumb-item type="link" :href="route('teams.index')" label="Teams" />
                <x-navigation.breadcrumb.breadcrumb-item type="link" :href="route('team.view.overview', ['slug' => $team->slug])" label="{{ $team->name . ' (' . $team->team_type->name . ')' }}" />
                @yield('breadcrumbs')
            </x-navigation.breadcrumb>
        </div>
        <div>
            <div class="flex justify-end gap-2">
                @yield('team-detail-quick-actions')
            </div>
        </div>
    </x-navigation.attached-navbar>
@endsection

@section('content')
    <x-layout.sidebar-main>
        <x-slot:sidebar>
            <x-navigation.sidebar-wrapper>
                <x-navigation.sidebar.sidebar-item icon="cube" label="Overview" :href="route('team.view.overview', ['slug' => $team->slug])" :active="request()->routeIs('team.view.overview')" />
                <x-navigation.sidebar.sidebar-item icon="collection" label="Tasks" :href="route('team.view.tasks', ['slug' => $team->slug])" :active="request()->routeIs('team.view.tasks')" />
                <x-navigation.sidebar.sidebar-item icon="user" label="Members" :href="route('team.view.members', ['slug' => $team->slug])" :active="request()->routeIs('team.view.members')" />
            </x-navigation.sidebar-wrapper>
        </x-slot:sidebar>

        @yield('team-detail-content')
    </x-layout.sidebar-main>
@endsection
