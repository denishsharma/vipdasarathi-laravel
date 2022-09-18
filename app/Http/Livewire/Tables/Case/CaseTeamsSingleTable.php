<?php

namespace App\Http\Livewire\Tables\Case;

use Livewire\Component;

class CaseTeamsSingleTable extends Component {
    public $case;

    public $teams = [];

    protected $listeners = [
        'refreshCaseTeamsTable' => 'refreshTable',
    ];

    public function refreshTable() {
        $this->teams = $this->case->teams;
    }

    public function mount($case) {
        $this->case = $case;
        $this->refreshTable();
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.tables.case.case-teams-single-table');
    }
}
