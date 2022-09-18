@extends('pages.cases.details.tasks.details.master', ['title' => ' - Activities', 'case' => $task->disaster_case])

@section('breadcrumbs')
    <x-navigation.breadcrumb.breadcrumb-item :active="true" label="Activities" />
@endsection

@section('task-detail-quick-actions')

@endsection

@section('task-detail-content')
    <div class="grid grid-cols-1 gap-5">
        <livewire:tables.task.task-activities-single-table :task="$task" />
    </div>
@endsection
