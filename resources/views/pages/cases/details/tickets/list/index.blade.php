@extends('pages.cases.details.master', ['title' => ' - Tickets', '$case' => $case])

@section('breadcrumbs')
    <x-navigation.breadcrumb.breadcrumb-item :active="true" label="Tickets" />
@endsection

@section('case-detail-quick-actions')
@endsection

@section('case-detail-content')
    <livewire:tables.case.case-tickets-single-table :case="$case" />
@endsection
