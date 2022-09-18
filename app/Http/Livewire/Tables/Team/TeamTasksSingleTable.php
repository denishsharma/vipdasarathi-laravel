<?php

namespace App\Http\Livewire\Tables\Team;

use Livewire\Component;

class TeamTasksSingleTable extends Component {
    public $team;
    public $status = 'all';

    public $tasks = [];

    protected $listeners = [
        'teamUpdated' => 'refreshData',
    ];

    public function refreshData() {
        if ($this->status === 'all') {
            $this->tasks = $this->team->tasks()->get();
        } else {
            $this->tasks = $this->team->tasks()->where('status', $this->status)->get();
        }
    }

    public function mount() {
        $this->refreshData();
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.tables.team.team-tasks-single-table');
    }
}
