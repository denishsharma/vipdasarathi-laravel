@extends('pages.cases.details.master', ['title' => ' - Overview', '$case' => $case])

@section('breadcrumbs')
    <x-navigation.breadcrumb.breadcrumb-item :active="true" label="Overview" />
@endsection

@section('case-detail-quick-actions')
    <x-button sm label="Update Casualties" @click="Livewire.emit('openModal', 'modals.edit-case-casualties-details', {{ json_encode(['case' => $case]) }})" />
@endsection

@section('case-detail-content')
    <div class="grid grid-cols-1 gap-5">
        <livewire:tables.case.case-data-single-table :case="$case" />
    </div>
@endsection
