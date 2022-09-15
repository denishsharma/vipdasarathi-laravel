<?php

namespace App\Http\Livewire\Tables\Team;

use Livewire\Component;

class TeamMembersSignleTable extends Component {
    public $team;

    protected $listeners = [
        'teamUpdated' => 'refreshData',
    ];

    public function refreshData() {
        $this->team = $this->team->fresh();
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.tables.team.team-members-signle-table');
    }
}
