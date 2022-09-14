@extends('layouts.general', ['title' => 'Cases', 'activeNav' => 'case'])

@section('attached-navbar')
    <x-navigation.attached-navbar>
        <div>
            <x-navigation.breadcrumb>
                <x-navigation.breadcrumb.breadcrumb-item :start="true" icon="home" type="link" :href="route('home')" label="Home" />
                <x-navigation.breadcrumb.breadcrumb-item :href="route('cases.index')" label="Cases" />
                @if (request()->routeIs('cases.index'))
                    <x-navigation.breadcrumb.breadcrumb-item :href="route('cases.index')" label="All Cases" :active="true" />
                @elseif (request()->routeIs('cases.index.active'))
                    <x-navigation.breadcrumb.breadcrumb-item :href="route('cases.index.active')" label="Active Cases" :active="true" />
                @elseif (request()->routeIs('cases.index.pending'))
                    <x-navigation.breadcrumb.breadcrumb-item :href="route('cases.index.pending')" label="Pending Cases" :active="true" />
                @elseif (request()->routeIs('cases.index.closed'))
                    <x-navigation.breadcrumb.breadcrumb-item :href="route('cases.index.closed')" label="Closed Cases" :active="true" />
                @endif
            </x-navigation.breadcrumb>
        </div>
        <div>
            <div class="flex justify-end gap-2">
                <x-button sm label="Add Case" @click="Livewire.emit('openModal', 'modals.edit-organization-details', {{ json_encode(['actionType' => 'add']) }})" />
            </div>
        </div>
    </x-navigation.attached-navbar>
@endsection

@section('content')
    <x-layout.sidebar-main>
        <x-slot:sidebar>
            <x-navigation.sidebar-wrapper>
                <x-navigation.sidebar.sidebar-item icon="collection" label="All Cases" :href="route('cases.index')" :active="request()->routeIs('cases.index')" />
                <x-navigation.sidebar.sidebar-group label="Status">
                    <x-navigation.sidebar.sidebar-item icon="dots-circle-horizontal" label="Active Cases" :href="route('cases.index.active')" :active="request()->routeIs('cases.index.active')" />
                    <x-navigation.sidebar.sidebar-item icon="question-mark-circle" label="Pending Cases" :href="route('cases.index.pending')" :active="request()->routeIs('cases.index.pending')" />
                    <x-navigation.sidebar.sidebar-item icon="check-circle" label="Closed Cases" :href="route('cases.index.closed')" :active="request()->routeIs('cases.index.closed')" />
                </x-navigation.sidebar.sidebar-group>
            </x-navigation.sidebar-wrapper>
        </x-slot:sidebar>

        <div class="overflow-x-auto border border-gray-200 rounded-lg soft-scrollbar">
            <livewire:tables.case.case-list-table heading="{{ $heading }}" description="{{ $description }}" :cases="$cases ?? null" />
        </div>
    </x-layout.sidebar-main>
@endsection
