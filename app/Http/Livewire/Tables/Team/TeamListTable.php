<?php

namespace App\Http\Livewire\Tables\Team;

use App\Models\Team;
use Livewire\Component;
use WireUi\Traits\Actions;

class TeamListTable extends Component {
    use Actions;

    public $heading;
    public $description;
    public $status = null;

    public $teams = [];

    protected $listeners = [
        'refreshTeamTable' => 'refreshTable',
    ];

    public function refreshTable() {
        if ($this->status) {
            $this->teams = Team::with('team_type')->whereStatus($this->status)->orderByDesc('created_at')->get();
        } else {
            $this->teams = Team::with('team_type')->orderByDesc('created_at')->get();
        }
    }

    public function openEditModal($team) {
        $this->emit('openModal', 'modals.edit-team-details', [
            'actionType' => 'edit',
            'team' => $team,
        ]);
    }

    public function mount($teams = null) {
        if ($teams) {
            $this->teams = $teams;
        } else {
            $this->refreshTable();
        }
    }

    public function openInactivateTeamModal(Team $team) {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => "This action will inactivate (<span class='font-semibold'>$team->name</span>) team.",
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, close it',
                'method' => 'inactivateTeam',
                'params' => $team,
                'color' => 'negative',
            ],
            'cancel' => [
                'label' => 'No, cancel it',
            ],
        ]);
    }

    public function openActivateTeamModal(Team $team) {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => "This action will activate (<span class='font-semibold'>$team->name</span>) team.",
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, close it',
                'method' => 'activateTeam',
                'params' => $team,
                'color' => 'positive',
            ],
            'cancel' => [
                'label' => 'No, cancel it',
            ],
        ]);
    }

    public function inactivateTeam(Team $team) {
        $team = Team::whereSlug($team->slug)->firstOrFail();

        $team->update([
            'status' => 'inactive',
        ]);

        $this->emit('refreshTeamTable');

        $this->notification()->success(
            'Team Inactivated',
            "Team (<span class='font-semibold'>$team->name</span>) has been inactivated."
        );
    }

    public function activateTeam(Team $team) {
        $team = Team::whereSlug($team->slug)->firstOrFail();

        $team->update([
            'status' => 'active',
        ]);

        $this->emit('refreshTeamTable');

        $this->notification()->success(
            'Team Activated',
            "Team (<span class='font-semibold'>$team->name</span>) has been activated."
        );
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.tables.team.team-list-table');
    }
}
