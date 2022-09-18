<?php

namespace App\Http\Livewire\Tables\Team;

use Livewire\Component;
use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;

class TeamDataSingleTable extends Component {
    public $team;
    public $currentTab = 'members';

    protected $listeners = [
        'teamUpdated' => 'refreshData',
    ];

    public function refreshData() {
        $this->team = $this->team->fresh();
    }

    public function changeTab($tab) {
        $this->currentTab = $tab;
        $this->refreshData();
    }

    public function removeAttachment(Attachment $attachment) {
        $this->team->attachments()->where('id', $attachment->id)->delete();

        Storage::delete('public/attachments/' . $attachment->filename);

        $this->emit('teamUpdated', $this->team);
        $this->emit('refreshTeamTasksTable');
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.tables.team.team-data-single-table');
    }
}
