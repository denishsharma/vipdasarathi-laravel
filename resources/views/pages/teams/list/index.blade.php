@extends('layouts.general', ['title' => 'Teams', 'activeNav' => 'team'])

@section('attached-navbar')
    <x-navigation.attached-navbar>
        <div>
            <x-navigation.breadcrumb>
                <x-navigation.breadcrumb.breadcrumb-item :start="true" icon="home" type="link" :href="route('home')" label="Home" />
                <x-navigation.breadcrumb.breadcrumb-item type="link" :href="route('teams.index')" label="Teams" />
                @if (request()->routeIs('teams.index'))
                    <x-navigation.breadcrumb.breadcrumb-item type="link" :href="route('teams.index')" label="All Teams" :active="true" />
                @elseif (request()->routeIs('teams.index.active'))
                    <x-navigation.breadcrumb.breadcrumb-item type="link" :href="route('teams.index.active')" label="Active Teams" :active="true" />
                @elseif (request()->routeIs('teams.index.inactive'))
                    <x-navigation.breadcrumb.breadcrumb-item type="link" :href="route('teams.index.inactive')" label="Inactive Teams" :active="true" />
                @endif
            </x-navigation.breadcrumb>
        </div>
        <div>
            <div class="flex justify-end gap-2">
                <x-button sm label="Add Team" @click="Livewire.emit('openModal', 'modals.edit-team-details', {{ json_encode(['actionType' => 'add']) }})" />
            </div>
        </div>
    </x-navigation.attached-navbar>
@endsection

@section('content')
    <x-layout.sidebar-main>
        <x-slot:sidebar>
            <x-navigation.sidebar-wrapper>
                <x-navigation.sidebar.sidebar-item icon="collection" label="All Teams" :href="route('teams.index')" :active="request()->routeIs('teams.index')" />
                <x-navigation.sidebar.sidebar-group label="Status">
                    <x-navigation.sidebar.sidebar-item icon="dots-circle-horizontal" label="Active Teams" :href="route('teams.index.active')" :active="request()->routeIs('teams.index.active')" />
                    <x-navigation.sidebar.sidebar-item icon="question-mark-circle" label="Inactive Teams" :href="route('teams.index.inactive')" :active="request()->routeIs('teams.index.inactive')" />
                </x-navigation.sidebar.sidebar-group>
            </x-navigation.sidebar-wrapper>
        </x-slot:sidebar>

        <div class="overflow-x-auto border border-gray-200 rounded-lg soft-scrollbar">
            <livewire:tables.team.team-list-table heading="{{ $heading }}" description="{{ $description }}" :status="$status" :cases="$cases ?? null" />
        </div>
    </x-layout.sidebar-main>
@endsection
