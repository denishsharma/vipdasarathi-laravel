<?php

namespace App\Http\Livewire\Tables\Task;

use Livewire\Component;

class TaskTicketsSingleTable extends Component {
    public $headless = false;
    public $status = 'all';
    public $task;

    public $tickets = [];

    protected $listeners = [
        'taskUpdated' => 'refreshData',
    ];

    public function refreshData() {
        $this->task = $this->task->fresh();
        if ($this->status == 'all') {
            $this->tickets = $this->task->tickets()->orderByDesc('created_at')->get();
        } else {
            if ($this->status == 'open') {
                $this->tickets = $this->task->tickets()->whereIn('status', ['open', 'task'])->orderByDesc('created_at')->get();
            } else {
                $this->tickets = $this->task->tickets()->where('status', $this->status)->orderByDesc('created_at')->get();
            }
        }
    }

    public function changeTab($tab) {
        $this->status = $tab;
        $this->refreshData();
    }

    public function mount() {
        $this->refreshData();
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.tables.task.task-tickets-single-table');
    }
}
