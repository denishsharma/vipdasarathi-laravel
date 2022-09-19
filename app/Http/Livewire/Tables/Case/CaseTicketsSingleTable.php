<?php

namespace App\Http\Livewire\Tables\Case;

use App\Models\Task;
use Livewire\Component;

class CaseTicketsSingleTable extends Component {
    public $case;

    public $status = 'all';

    public $taskSlug;
    public $task;

    public $tickets = [];

    protected $listeners = [
        'refreshCaseTicketsTable' => 'refreshData',
    ];

    public function updatedTaskSlug() {
        $this->task = Task::whereSlug($this->taskSlug)->first();
        $this->refreshData();
    }

    public function refreshData() {
        $this->case = $this->case->fresh();
        if ($this->status == 'all') {
            if ($this->task) {
                $this->tickets = $this->task->tickets()->orderByDesc('created_at')->get();
            } else {
                $this->tickets = $this->case->has_many_tickets()->orderByDesc('created_at')->get();
            }
        } else {
            if ($this->status == 'open') {
                if ($this->task) {
                    $this->tickets = $this->task->tickets()->whereIn('status', ['open', 'task'])->orderByDesc('created_at')->get();
                } else {
                    $this->tickets = $this->case->has_many_tickets()->whereIn('status', ['open', 'task'])->orderByDesc('created_at')->get();
                }
            } else {
                if ($this->task) {
                    $this->tickets = $this->task->tickets()->where('status', $this->status)->orderByDesc('created_at')->get();
                } else {
                    $this->tickets = $this->case->has_many_tickets()->where('status', $this->status)->orderByDesc('created_at')->get();
                }
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
        return view('livewire.tables.case.case-tickets-single-table');
    }
}
