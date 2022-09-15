<?php

namespace App\Http\Livewire\Tables\DisasterType;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\DisasterType;

class DisasterTypeSettingTable extends Component {
    use Actions;

    public $description;
    public $currentTab = 'active';

    public $disasterTypes = [];

    protected $listeners = [
        'refreshDisasterTypeTable' => 'refreshTable',
        'disasterTypeChangeTab' => 'changeTab',
    ];

    public function refreshTable($archived = false) {
        if ($archived || $this->currentTab == 'archived') {
            $this->disasterTypes = DisasterType::onlyTrashed()->orderByDesc('created_at')->get();
        } else {
            $this->disasterTypes = DisasterType::orderByDesc('created_at')->get();
        }
    }

    public function changeTab($tab) {
        $this->currentTab = $tab;

        if ($tab == 'archived') {
            $this->description = 'Here you will find all the archived/deleted disaster types. You can restore the deleted disaster types from here.';
            $this->refreshTable(true);
        } else {
            $this->description = 'Here you will find all the disaster types at once place. Manage and view cases as per types.';
            $this->refreshTable();
        }
    }

    public function openEditModal($disasterType) {
        $this->emit('openModal', 'modals.edit-disaster-type-details', [
            'actionType' => 'edit',
            'disasterType' => $disasterType,
        ]);
    }

    public function mount() {
        $this->refreshTable();
    }

    public function openDeleteModal($disasterType) {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Delete the Disaster Type?',
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, delete it',
                'method' => 'deleteDisasterType',
                'params' => $disasterType,
                'color' => 'negative',
            ],
            'cancel' => [
                'label' => 'No, cancel it',
                'method' => 'cancelDelete',
            ],
        ]);
    }

    public function openRestoreModal($disasterType) {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Restore the Disaster Type?',
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, restore it',
                'method' => 'restoreDisasterType',
                'params' => $disasterType,
                'color' => 'positive',
            ],
            'cancel' => [
                'label' => 'No, cancel it',
                'method' => 'cancelRestore',
            ],
        ]);
    }

    public function deleteDisasterType($disasterType) {
        $disasterType = DisasterType::whereSlug($disasterType['slug'])->firstOrFail();

        if ($disasterType->cases()->count() > 0) {
            $this->notification()->error(
                'Error',
                'You cannot delete this disaster type because it is being used by some cases.',
            );
        } else {
            $disasterType->delete();

            $this->emit('refreshDisasterTypeTable');

            $this->notification()->success(
                'Success',
                'Disaster Type deleted successfully.',
            );
        }
    }

    public function restoreDisasterType($disasterType) {
        $disasterType = DisasterType::withTrashed()->whereSlug($disasterType['slug'])->firstOrFail();

        $disasterType->restore();

        $this->emit('refreshDisasterTypeTable');

        $this->notification()->success(
            'Success',
            'Disaster Type restored successfully.',
        );
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.tables.disaster-type.disaster-type-setting-table');
    }
}
