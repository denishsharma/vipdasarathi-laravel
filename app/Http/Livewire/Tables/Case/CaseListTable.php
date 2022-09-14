<?php

namespace App\Http\Livewire\Tables\Case;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\DisasterCase;

class CaseListTable extends Component {
    use Actions;

    public $heading;
    public $description;
    public $status = null;

    public $cases = [];

    protected $listeners = [
        'refreshCaseTable' => 'refreshTable',
    ];

    public function refreshTable() {
        if ($this->status) {
            $this->cases = DisasterCase::with('disaster_type')->whereStatus($this->status)->orderByDesc('created_at')->get();
        } else {
            $this->cases = DisasterCase::with('disaster_type')->orderByDesc('created_at')->get();
        }
    }

    public function mount($cases = null) {
        if ($cases) {
            $this->cases = $cases;
        } else {
            $this->refreshTable();
        }
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.tables.case.case-list-table');
    }
}
