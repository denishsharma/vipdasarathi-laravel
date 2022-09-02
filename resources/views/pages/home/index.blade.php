@extends('layouts.general', ['title' => 'Home', 'activeNav' => 'home'])

@section('attached-navbar')
    <x-navigation.attached-navbar>
        <x-button sm label="Add User" @click="Livewire.emit('openModal', 'modals.edit-user-details', {{ json_encode(['actionType' => 'add']) }})" />
        <x-button sm label="Add Organization" @click="Livewire.emit('openModal', 'modals.edit-organization-details', {{ json_encode(['actionType' => 'add']) }})" />
    </x-navigation.attached-navbar>
@endsection

@section('content')
    <x-layout.sidebar-main>
        <x-slot:sidebar>
            sidebar
        </x-slot:sidebar>

        main
    </x-layout.sidebar-main>
@endsection
