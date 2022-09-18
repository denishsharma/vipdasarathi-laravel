@extends('layouts.general', ['title' => 'Case Details'.$title, 'activeNav' => 'case'])

@section('attached-navbar')
    <x-navigation.attached-navbar>
        <div>
            <x-navigation.breadcrumb>
                <x-navigation.breadcrumb.breadcrumb-item :start="true" icon="home" type="link" :href="route('home')" label="Home" />
                <x-navigation.breadcrumb.breadcrumb-item type="link" :href="route('cases.index')" label="Cases" />
                <x-navigation.breadcrumb.breadcrumb-item type="link" :href="route('case.view.overview', ['slug' => $case->slug])" :label="$case->title" />
                @yield('breadcrumbs')
            </x-navigation.breadcrumb>
        </div>
        <div>
            <div class="flex justify-end gap-2">
                <x-button sm label="Edit Details" @click="Livewire.emit('openModal', 'modals.edit-case-details', {{ json_encode(['actionType' => 'edit', 'case' => $case]) }})" />
                <x-button sm label="Add Task" @click="Livewire.emit('openModal', 'modals.edit-task-details', {{ json_encode(['actionType' => 'add', 'case' => $case, 'taskCategory' => 'general']) }})" />
                @yield('case-detail-quick-actions')
            </div>
        </div>
    </x-navigation.attached-navbar>
@endsection

@section('content')
    <x-layout.sidebar-main>
        <x-slot:sidebar>
            <x-navigation.sidebar-wrapper>
                <x-navigation.sidebar.sidebar-item icon="cube" label="Overview" :href="route('case.view.overview', ['slug' => $case->slug])" :active="request()->routeIs('case.view.overview')" />
                <x-navigation.sidebar.sidebar-group label="Details">
                    <x-navigation.sidebar.sidebar-item icon="receipt-refund" label="Demands" :href="route('case.view.demands', ['slug' => $case->slug])" :active="request()->routeIs('case.view.demands')" />
                    <x-navigation.sidebar.sidebar-item icon="user-group" label="Teams" :href="route('case.view.teams', ['slug' => $case->slug])" :active="request()->routeIs('case.view.teams')" />
                    <x-navigation.sidebar.sidebar-item icon="collection" label="Tasks" :href="route('case.view.tasks', ['slug' => $case->slug])" :active="request()->routeIs('case.view.tasks')" />
                    <x-navigation.sidebar.sidebar-item icon="ticket" label="Tickets" :href="route('case.view.tickets', ['slug' => $case->slug])" :active="request()->routeIs('case.view.tickets')" />
                    <x-navigation.sidebar.sidebar-item icon="home" label="Shelters" :href="route('case.view.shelters', ['slug' => $case->slug])" :active="request()->routeIs('case.view.shelters')" />
                </x-navigation.sidebar.sidebar-group>
            </x-navigation.sidebar-wrapper>
        </x-slot:sidebar>

        @yield('case-detail-content')
    </x-layout.sidebar-main>
@endsection
