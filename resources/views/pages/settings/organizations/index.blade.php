@extends('pages.settings.master')

@section('breadcrumbs')
    <x-navigation.breadcrumb.breadcrumb-item :href="route('settings.organization.index')" label="Organizations" :active="true" />
@endsection

@section('setting-quick-actions')
    <x-button sm label="Add Organization" @click="Livewire.emit('openModal', 'modals.edit-organization-details', {{ json_encode(['actionType' => 'add']) }})" />
@endsection

@section('setting-content')
    <div class="grid grid-cols-1 gap-5">
        <div class="select-none rounded-lg border border-gray-200 px-5">
            <div class="text-sm font-medium text-center text-gray-500">
                <ul x-data="{ tab: 'active' }" class="flex flex-wrap -mb-px gap-2 justify-center">
                    <li>
                        <a @click="Livewire.emit('organizationChangeTab', 'active'); tab='active';" :class="tab=='active' ? 'text-primary-600 border-primary-600' : 'border-transparent text-gray-700 hover:text-gray-600 hover:border-gray-300'" class="cursor-pointer inline-block py-2.5 px-3 rounded-t-lg border-b-2">Active</a>
                    </li>
                    <li>
                        <a @click="Livewire.emit('organizationChangeTab', 'archived'); tab='archived'" :class="tab=='archived' ? 'text-primary-600 border-primary-600' : 'border-transparent text-gray-700 hover:text-gray-600 hover:border-gray-300'" class="cursor-pointer inline-block py-2.5 px-3 rounded-t-lg border-b-2" aria-current="page">Archived</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="overflow-x-auto border border-gray-200 rounded-lg soft-scrollbar">
            <livewire:tables.organization.organization-setting-table description="Here you will find all the organizations that have been created and has access to the platform. Manage the organization's details, users, and other settings from one place." />
        </div>
    </div>
@endsection
