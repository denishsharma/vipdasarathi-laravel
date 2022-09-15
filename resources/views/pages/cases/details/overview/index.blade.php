@extends('pages.cases.details.master', ['title' => ' - Overview', '$case' => $case])

@section('breadcrumbs')
    <x-navigation.breadcrumb.breadcrumb-item :active="true" label="Overview" />
@endsection

@section('case-detail-quick-actions')
    <x-button sm label="Edit Details" @click="Livewire.emit('openModal', 'modals.edit-case-details', {{ json_encode(['actionType' => 'edit', 'case' => $case]) }})" />
    <x-button sm label="Update Casualties" @click="Livewire.emit('openModal', 'modals.edit-organization-details', {{ json_encode(['actionType' => 'edit', 'case' => $case]) }})" />
@endsection

@section('case-detail-content')

@endsection
