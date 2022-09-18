@extends('pages.cases.details.master', ['title' => ' - Teams', '$case' => $case])

@section('breadcrumbs')
    <x-navigation.breadcrumb.breadcrumb-item :active="true" label="Teams" />
@endsection

@section('case-detail-quick-actions')
@endsection

@section('case-detail-content')
    <livewire:tables.case.case-teams-single-table :case="$case" />
@endsection
