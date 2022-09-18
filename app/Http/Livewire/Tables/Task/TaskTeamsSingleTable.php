<?php

namespace App\Http\Livewire\Tables\Task;

use Livewire\Component;

class TaskTeamsSingleTable extends Component {
    public $task;

    protected $listeners = [
        'taskUpdated' => 'refreshData',
    ];

    public function refreshData() {
        $this->task = $this->task->fresh();
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.tables.task.task-teams-single-table');
    }
}
