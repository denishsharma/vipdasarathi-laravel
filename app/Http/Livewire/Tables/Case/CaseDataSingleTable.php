<?php

namespace App\Http\Livewire\Tables\Case;

use Livewire\Component;
use WireUi\Traits\Actions;

class CaseDataSingleTable extends Component {
    use Actions;

    public $currentTab = 'activities';

    public $case;

    protected $listeners = [
        'caseUpdated' => 'refreshData',
    ];

    public function refreshData() {
        $this->case = $this->case->fresh();
    }

    public function changeTab($tab) {
        $this->currentTab = $tab;
    }

    public function mount() {
        $this->refreshData();
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.tables.case.case-data-single-table');
    }
}
