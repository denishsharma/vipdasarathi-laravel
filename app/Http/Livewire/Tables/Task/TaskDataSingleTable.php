<?php

namespace App\Http\Livewire\Tables\Task;

use Livewire\Component;

class TaskDataSingleTable extends Component {
    public $task;

    public $currentTab = 'teams';

    protected $listeners = [
        'taskUpdated' => 'refreshData',
    ];

    public function refreshData() {
        $this->task = $this->task->fresh();
    }

    public function changeTab($tab) {
        $this->currentTab = $tab;
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.tables.task.task-data-single-table');
    }
}
