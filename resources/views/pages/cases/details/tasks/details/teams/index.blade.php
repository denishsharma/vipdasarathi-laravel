@extends('pages.cases.details.tasks.details.master', ['title' => ' - Teams', 'case' => $task->disaster_case])

@section('breadcrumbs')
    <x-navigation.breadcrumb.breadcrumb-item :active="true" label="Teams" />
@endsection

@section('task-detail-content')
    <div class="grid grid-cols-1 gap-5">
        <livewire:tables.task.task-teams-single-table :task="$task" />
    </div>
@endsection
