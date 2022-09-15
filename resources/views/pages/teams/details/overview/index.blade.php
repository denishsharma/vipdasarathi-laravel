@extends('pages.teams.details.master', ['title' => ' - Overview', 'team' => $team])

@section('breadcrumbs')
    <x-navigation.breadcrumb.breadcrumb-item :active="true" label="Overview" />
@endsection

@section('team-detail-quick-actions')
    <x-button sm label="Edit Team Details" @click="Livewire.emit('openModal', 'modals.edit-team-details', {{ json_encode(['actionType' => 'edit', 'team' => $team]) }})" />
    <x-button sm label="Manage Members" @click="Livewire.emit('openModal', 'modals.edit-team-details', {{ json_encode(['actionType' => 'manage-members', 'team' => $team]) }})" />
@endsection

@section('team-detail-content')
    <div class="grid grid-cols-1 gap-5">
        <livewire:tables.team.team-data-single-table :team="$team" />
        <livewire:tables.team.team-members-signle-table :team="$team" />
    </div>
@endsection
