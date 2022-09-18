@extends('pages.cases.details.tasks.details.master', ['title' => ' - Attachments', 'case' => $task->disaster_case])

@section('breadcrumbs')
    <x-navigation.breadcrumb.breadcrumb-item :active="true" label="Attachments" />
@endsection

@section('task-detail-quick-actions')

@endsection

@section('task-detail-content')
    <div class="grid grid-cols-1 gap-5">
        <livewire:tables.task.task-attachments-single-table wire:key="case-attachments" :task="$task" />
    </div>
@endsection
