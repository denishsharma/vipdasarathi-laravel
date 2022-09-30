<?php

namespace App\Http\Livewire\Tables\DemandType;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\DemandType;

class DemandTypeSettingTable extends Component {
    use Actions;

    public $description;
    public $currentTab = 'active';

    public $demandTypes = [];

    protected $listeners = [
        'refreshDemandTypeTable' => 'refreshTable',
        'demandTypeChangeTab' => 'changeTab',
    ];

    public function refreshTable($archived = false) {
        if ($archived || $this->currentTab == 'archived') {
            $this->demandTypes = DemandType::onlyTrashed()->orderByDesc('created_at')->get();
        } else {
            $this->demandTypes = DemandType::orderByDesc('created_at')->get();
        }
    }

    public function changeTab($tab) {
        $this->currentTab = $tab;

        if ($tab == 'archived') {
            $this->description = 'Here you will find all the archived/deleted demand types. You can restore the deleted demand types from here.';
            $this->refreshTable(true);
        } else {
            $this->description = 'Here you will find all the demand types at once place. Manage and view cases as per types.';
            $this->refreshTable();
        }
    }

    public function openEditModal($demandType) {
        $this->emit('openModal', 'modals.edit-demand-type-details', [
            'actionType' => 'edit',
            'demandType' => $demandType,
        ]);
    }

    public function mount() {
        $this->refreshTable();
    }

    public function openDeleteModal($demandType) {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Delete the Demand Type?',
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, delete it',
                'method' => 'deleteDemandType',
                'params' => $demandType,
                'color' => 'negative',
            ],
            'cancel' => [
                'label' => 'No, cancel it',
            ],
        ]);
    }

    public function openRestoreModal($demandType) {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Restore the Demand Type?',
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, restore it',
                'method' => 'restoreDemandType',
                'params' => $demandType,
                'color' => 'positive',
            ],
            'cancel' => [
                'label' => 'No, cancel it',
            ],
        ]);
    }

    public function deleteDemandType($demandType) {
        $demandType = DemandType::whereSlug($demandType['slug'])->firstOrFail();

        if ($demandType->demands_count > 0) {
            $this->notification()->error(
                'Error',
                'You cannot delete this demand type as it is associated with some demands.'
            );
        } else {
            $demandType->delete();

            $this->notification()->success(
                'Success',
                'Demand Type deleted successfully.'
            );

            $this->refreshTable();
        }
    }

    public function restoreDemandType($demandType) {
        $demandType = DemandType::whereSlug($demandType['slug'])->withTrashed()->firstOrFail();

        $demandType->restore();

        $this->emit('refreshDemandTypeTable');

        $this->notification()->success(
            'Success',
            'Demand Type restored successfully.'
        );
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.tables.demand-type.demand-type-setting-table');
    }
}
