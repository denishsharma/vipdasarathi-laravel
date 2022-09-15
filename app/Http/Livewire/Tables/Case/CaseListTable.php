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

    public function openEditModal($case) {
        $this->emit('openModal', 'modals.edit-case-details', [
            'actionType' => 'edit',
            'case' => $case,
        ]);
    }

    public function mount($cases = null) {
        if ($cases) {
            $this->cases = $cases;
        } else {
            $this->refreshTable();
        }
    }

    public function openCloseCaseModal(DisasterCase $case) {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => "This action will close (<span class='font-semibold'>$case->title</span>) case.",
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, close it',
                'method' => 'closeCase',
                'params' => $case,
                'color' => 'negative',
            ],
            'cancel' => [
                'label' => 'No, cancel it',
            ],
        ]);
    }

    public function openRestoreCaseModal(DisasterCase $case) {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => "This action will change status to active of (<span class='font-semibold'>$case->title</span>) case.",
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, change it',
                'method' => 'restoreCase',
                'params' => $case,
                'color' => 'positive',
            ],
            'cancel' => [
                'label' => 'No, cancel it',
            ],
        ]);
    }

    public function closeCase($case) {
        $case = DisasterCase::whereSlug($case['slug'])->firstOrFail();

        $case->update([
            'status' => 'closed',
        ]);

        $this->emit('refreshCaseTable');

        $this->notification()->success(
            $title = 'Case closed successfully!',
            $description = "The case (<span class='font-semibold'>$case->title</span>) has been closed successfully.",
        );
    }

    public function restoreCase($case) {
        $case = DisasterCase::whereSlug($case['slug'])->firstOrFail();

        $case->update([
            'status' => 'active',
        ]);

        $this->emit('refreshCaseTable');

        $this->notification()->success(
            $title = 'Case activated successfully!',
            $description = "The case (<span class='font-semibold'>$case->title</span>) has been activated successfully.",
        );
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.tables.case.case-list-table');
    }
}
