<?php

namespace App\Http\Livewire\Tables\Case;

use App\Models\Task;
use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\DisasterCase;

class CaseTasksSingleTable extends Component {
    use Actions;

    public $headerLess = false;
    public $heading;
    public $description;

    public $currentTab = 'all';
    public $currentCategory = 'all';

    public $case;

    public $tasks = [];

    protected $listeners = [
        'refreshCaseTasksTable' => 'refreshTable',
    ];

    public function getCurrentCategoryName(): string {
        return match ($this->currentCategory) {
            'all' => 'All',
            'general' => 'General Tasks',
            'demands' => 'Demand of Resources',
            'tickets' => 'Tickets & Issues',
        };
    }

    public function refreshTable() {
        if ($this->currentTab == 'all') {
            $this->description = 'Here you can see all tasks for this case. You can also edit and view the task details.';
            if ($this->currentCategory == 'all') {
                $this->heading = 'All Tasks';
                $this->tasks = $this->case->tasks()->with('task_type', 'teams')->orderByDesc('created_at')->get();
            } else {
                $this->heading = "All Tasks for " . $this->getCurrentCategoryName();
                $this->tasks = $this->case->tasks()->with('task_type', 'teams')->whereTaskCategory($this->currentCategory)->orderByDesc('created_at')->get();
            }
        } else {
            $this->description = 'Here you can see all ' . $this->currentTab . ' tasks for this case that are assigned to you. You can also edit/view/restore the task.';
            if ($this->currentCategory == 'all') {
                $this->heading = ucwords($this->currentTab) . ' Tasks';
                $this->tasks = $this->case->tasks()->with('task_type', 'teams')->whereStatus($this->currentTab)->orderByDesc('created_at')->get();
            } else {
                $this->heading = ucfirst($this->currentTab) . " Tasks for " . $this->getCurrentCategoryName();
                $this->tasks = $this->case->tasks()->with('task_type', 'teams')->whereStatus($this->currentTab)->whereTaskCategory($this->currentCategory)->orderByDesc('created_at')->get();
            }
        }
    }

    public function changeTab($tab) {
        $this->currentTab = $tab;
        $this->refreshTable();
    }

    public function changeCategory($category) {
        $this->currentCategory = $category;
        $this->refreshTable();
    }

    public function openEditModal($task) {
        $this->emit('openModal', 'modals.edit-task-details', [
            'actionType' => 'edit',
            'case' => $this->case,
            'task' => $task,
        ]);
    }

    public function mount() {
        $this->refreshTable();
    }

    public function openCompleteTaskModal(Task $task) {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => "This action will complete (<span class='font-semibold'>$task->subject</span>) task.",
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, complete it',
                'method' => 'completeTask',
                'params' => $task,
                'color' => 'positive',
            ],
            'cancel' => [
                'label' => 'No, cancel it',
            ],
        ]);
    }

    public function openDeleteModal(Task $task) {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => "This action will delete (<span class='font-semibold'>$task->subject</span>) task.",
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, delete it',
                'method' => 'deleteTask',
                'params' => $task,
                'color' => 'negative',
            ],
            'cancel' => [
                'label' => 'No, cancel it',
            ],
        ]);
    }

    public function openRestoreModal(Task $task) {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => "This action will restore (<span class='font-semibold'>$task->subject</span>) task.",
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, restore it',
                'method' => 'restoreTask',
                'params' => $task,
                'color' => 'positive',
            ],
            'cancel' => [
                'label' => 'No, cancel it',
            ],
        ]);
    }

    public function completeTask($task) {
        $task = Task::whereSlug($task['slug'])->first();

        $task->update([
            'status' => 'completed',
        ]);

        $this->emit('refreshCaseTasksTable');

        $this->notification()->success(
            'Task completed successfully.',
            "Task (<span class='font-semibold'>$task->subject</span>) completed successfully."
        );
    }

    public function deleteTask($task) {
        $task = Task::whereSlug($task['slug'])->first();

        $task->update([
            'status' => 'archived',
        ]);

        $this->emit('refreshCaseTasksTable');

        $this->notification()->success(
            'Task deleted successfully.',
            "Task (<span class='font-semibold'>$task->subject</span>) deleted successfully."
        );
    }

    public function restoreTask($task) {
        $task = Task::whereSlug($task['slug'])->first();

        $task->update([
            'status' => 'active',
        ]);

        $this->emit('refreshCaseTasksTable');

        $this->notification()->success(
            'Task restored successfully.',
            "Task (<span class='font-semibold'>$task->subject</span>) restored successfully."
        );
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.tables.case.case-tasks-single-table');
    }
}
