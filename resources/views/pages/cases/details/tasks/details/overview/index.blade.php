@extends('pages.cases.details.tasks.details.master', ['title' => ' - Overview', 'case' => $task->disaster_case])

@section('breadcrumbs')
    <x-navigation.breadcrumb.breadcrumb-item :active="true" label="Overview" />
@endsection

@section('task-detail-quick-actions')

@endsection

@section('task-detail-content')
    <div class="grid grid-cols-1 gap-5">
        <livewire:tables.task.task-data-single-table :task="$task" />
        <livewire:tables.task.task-activities-single-table :task="$task" />
    </div>
@endsection
