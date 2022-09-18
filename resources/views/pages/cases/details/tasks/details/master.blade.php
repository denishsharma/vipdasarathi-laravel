@extends('layouts.general', ['title' => 'Task Details'.$title, 'activeNav' => 'case'])

@section('attached-navbar')
    <x-navigation.attached-navbar>
        <div>
            <x-navigation.breadcrumb>
                <x-navigation.breadcrumb.breadcrumb-item :start="true" icon="home" type="link" :href="route('home')" label="Home" />
                <x-navigation.breadcrumb.breadcrumb-item type="link" :href="route('cases.index')" label="Cases" />
                <x-navigation.breadcrumb.breadcrumb-item type="link" :href="route('case.view.overview', ['slug' => $case->slug])" :label="$case->title" />
                <x-navigation.breadcrumb.breadcrumb-item type="link" :href="route('case.view.tasks', ['slug' => $case->slug])" label="Tasks" />
                <x-navigation.breadcrumb.breadcrumb-item type="link" :href="route('task.view.overview', ['slug' => $task->slug])" :label="$task->subject" />
                @yield('breadcrumbs')
            </x-navigation.breadcrumb>
        </div>
        <div>
            <div class="flex justify-end gap-2">
                <x-button sm label="Update Status" @click="Livewire.emit('openModal', 'modals.update-task-status', {{ json_encode(['task' => $task]) }})" />
                <x-button sm label="Edit Details" @click="Livewire.emit('openModal', 'modals.edit-task-details', {{ json_encode(['actionType' => 'edit', 'case' => $task->disaster_case, 'task' => $task]) }})" />
                <x-button sm label="Manage Teams" @click="Livewire.emit('openModal', 'modals.edit-task-details', {{ json_encode(['actionType' => 'manage-teams', 'case' => $task->disaster_case, 'task' => $task]) }})" />
                <x-button sm label="Manage Attachments" @click="Livewire.emit('openModal', 'modals.edit-task-details', {{ json_encode(['actionType' => 'manage-attachments', 'case' => $task->disaster_case, 'task' => $task]) }})" />
                @yield('task-detail-quick-actions')
                <x-button sm positive label="Add Update" @click="Livewire.emit('openModal', 'modals.edit-task-update-details', {{ json_encode(['actionType' => 'add', 'task' => $task]) }})" />
            </div>
        </div>
    </x-navigation.attached-navbar>
@endsection

@section('content')
    <x-layout.sidebar-main>
        <x-slot:sidebar>
            <x-navigation.sidebar-wrapper>
                <x-navigation.sidebar.sidebar-item icon="cube" label="Overview" :href="route('task.view.overview', ['slug' => $task->slug])" :active="request()->routeIs('task.view.overview')" />
                <x-navigation.sidebar.sidebar-item icon="menu-alt-1" label="Activities" :href="route('task.view.activities', ['slug' => $task->slug])" :active="request()->routeIs('task.view.activities')" />
                <x-navigation.sidebar.sidebar-item icon="user-group" label="Teams" :href="route('task.view.teams', ['slug' => $task->slug])" :active="request()->routeIs('task.view.teams')" />
                <x-navigation.sidebar.sidebar-item icon="ticket" label="Tickets" :href="route('task.view.tickets', ['slug' => $task->slug])" :active="request()->routeIs('task.view.tickets')" />
                <x-navigation.sidebar.sidebar-item icon="paper-clip" label="Attachments" :href="route('task.view.attachments', ['slug' => $task->slug])" :active="request()->routeIs('task.view.attachments')" />
            </x-navigation.sidebar-wrapper>
        </x-slot:sidebar>

        @yield('task-detail-content')
    </x-layout.sidebar-main>
@endsection
