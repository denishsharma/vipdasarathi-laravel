@extends('layouts.empty', ['title' => 'Home'])

@section('body')
    <div class="flex justify-center items-center h-screen">
        <div class="w-1/2">
            <h1 class="text-2xl text-center">Welcome to the home page</h1>
        </div>

        <x-button sm label="Add User" @click="Livewire.emit('openModal', 'modals.edit-user-details', {{ json_encode(['actionType' => 'add']) }})" />
        <x-button sm label="Add Organization" @click="Livewire.emit('openModal', 'modals.edit-organization-details', {{ json_encode(['actionType' => 'add']) }})" />
    </div>
@endsection
