@extends('pages.cases.details.master', ['title' => ' - Tasks', '$case' => $case])

@section('breadcrumbs')
    <x-navigation.breadcrumb.breadcrumb-item :active="true" label="Tasks" />
@endsection

@section('case-detail-quick-actions')
@endsection

@section('case-detail-content')
    <livewire:tables.case.case-tasks-single-table :case="$case" />
@endsection
