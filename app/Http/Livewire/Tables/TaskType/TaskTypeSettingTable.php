<?php

namespace App\Http\Livewire\Tables\TaskType;

use Livewire\Component;
use App\Models\TaskType;
use WireUi\Traits\Actions;

class TaskTypeSettingTable extends Component {
    use Actions;

    public $description;
    public $currentTab = 'active';

    public $taskTypes = [];

    protected $listeners = [
        'refreshTaskTypeTable' => 'refreshTable',
        'taskTypeChangeTab' => 'changeTab',
    ];

    public function refreshTable($archived = false) {
        if ($archived || $this->currentTab == 'archived') {
            $this->taskTypes = TaskType::onlyTrashed()->orderByDesc('created_at')->get();
        } else {
            $this->taskTypes = TaskType::orderByDesc('created_at')->get();
        }
    }

    public function changeTab($tab) {
        $this->currentTab = $tab;

        if ($tab == 'archived') {
            $this->description = 'Here you will find all the archived/deleted task types. You can restore the deleted task types from here.';
            $this->refreshTable(true);
        } else {
            $this->description = 'Here you will find all the task types at once place. Manage and view cases as per types.';
            $this->refreshTable();
        }
    }

    public function openEditModal($taskType) {
        $this->emit('openModal', 'modals.edit-task-type-details', [
            'actionType' => 'edit',
            'taskType' => $taskType,
        ]);
    }

    public function mount() {
        $this->refreshTable();
    }

    public function openDeleteModal($taskType) {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Delete the Task Type?',
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, delete it',
                'method' => 'deleteTaskType',
                'params' => $taskType,
                'color' => 'negative',
            ],
            'cancel' => [
                'label' => 'No, cancel it',
            ],
        ]);
    }

    public function openRestoreModal($taskType) {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Restore the Task Type?',
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, restore it',
                'method' => 'restoreTaskType',
                'params' => $taskType,
                'color' => 'positive',
            ],
            'cancel' => [
                'label' => 'No, cancel it',
            ],
        ]);
    }

    public function deleteTaskType($taskType) {
        $taskType = TaskType::whereSlug($taskType['slug'])->firstOrFail();

        if ($taskType->tasks()->count() > 0) {
            $this->notification()->error(
                'Error',
                'You cannot delete this task type because it is being used by some tasks.',
            );
        } else {
            $taskType->delete();

            $this->emit('refreshTaskTypeTable');

            $this->notification()->success(
                'Success',
                'Task Type deleted successfully.',
            );
        }
    }

    public function restoreTaskType($taskType) {
        $taskType = TaskType::withTrashed()->whereSlug($taskType['slug'])->firstOrFail();

        $taskType->restore();

        $this->emit('refreshTaskTypeTable');

        $this->notification()->success(
            'Success',
            'Task Type restored successfully.',
        );
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.tables.task-type.task-type-setting-table');
    }
}
