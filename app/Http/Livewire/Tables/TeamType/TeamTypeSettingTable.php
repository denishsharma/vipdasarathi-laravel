<?php

namespace App\Http\Livewire\Tables\TeamType;

use Livewire\Component;
use App\Models\TeamType;
use WireUi\Traits\Actions;

class TeamTypeSettingTable extends Component {
    use Actions;

    public $description;
    public $currentTab = 'active';

    public $teamTypes = [];

    protected $listeners = [
        'refreshTeamTypeTable' => 'refreshTable',
        'teamTypeChangeTab' => 'changeTab',
    ];

    public function refreshTable($archived = false) {
        if ($archived || $this->currentTab == 'archived') {
            $this->teamTypes = TeamType::onlyTrashed()->orderByDesc('created_at')->get();
        } else {
            $this->teamTypes = TeamType::orderByDesc('created_at')->get();
        }
    }

    public function changeTab($tab) {
        $this->currentTab = $tab;

        if ($tab == 'archived') {
            $this->description = 'Here you will find all the archived/deleted team types. You can restore the deleted team types from here.';
            $this->refreshTable(true);
        } else {
            $this->description = 'Here you will find all the team types at once place. Manage and view teams as per types.';
            $this->refreshTable();
        }
    }

    public function openEditModal($teamType) {
        $this->emit('openModal', 'modals.edit-team-type-details', [
            'actionType' => 'edit',
            'teamType' => $teamType,
        ]);
    }

    public function mount() {
        $this->refreshTable();
    }

    public function openDeleteModal($teamType) {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Delete the Team Type?',
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, delete it',
                'method' => 'deleteTeamType',
                'params' => $teamType,
                'color' => 'negative',
            ],
            'cancel' => [
                'label' => 'No, cancel it',
            ],
        ]);
    }

    public function openRestoreModal($teamType) {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Restore the Team Type?',
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, restore it',
                'method' => 'restoreTeamType',
                'params' => $teamType,
                'color' => 'positive',
            ],
            'cancel' => [
                'label' => 'No, cancel it',
            ],
        ]);
    }

    public function deleteTeamType($teamType) {
        $teamType = TeamType::whereSlug($teamType['slug'])->firstOrFail();

        if ($teamType->teams_count > 0) {
            $this->notification()->error(
                'Error',
                'You cannot delete this team type as it is being used by some teams.'
            );
        } else {
            $teamType->delete();

            $this->emit('refreshTeamTypeTable');

            $this->notification()->success(
                'Success',
                'Team Type deleted successfully.'
            );
        }
    }

    public function restoreTeamType($teamType) {
        $teamType = TeamType::onlyTrashed()->whereSlug($teamType['slug'])->firstOrFail();

        $teamType->restore();

        $this->emit('refreshTeamTypeTable');

        $this->notification()->success(
            'Success',
            'Team Type restored successfully.'
        );
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.tables.team-type.team-type-setting-table');
    }
}
