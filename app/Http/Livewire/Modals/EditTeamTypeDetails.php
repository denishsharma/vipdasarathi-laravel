<?php

namespace App\Http\Livewire\Modals;

use App\Models\TeamType;
use LivewireUI\Modal\ModalComponent;

class EditTeamTypeDetails extends ModalComponent {
    public string $actionType;

    public $name;
    public $slug;
    public $description;

    public $teamType;

    protected $rules = [
        'name' => 'required',
        'slug' => 'required|unique:team_types',
    ];

    protected $messages = [
        'slug.unique' => 'Team type already exists.',
    ];

    public function updateTeamType() {
        $this->validate([
            'name' => 'required',
        ]);

        $teamType = TeamType::whereSlug($this->teamType->slug)->firstOrFail();
        $teamType->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->emit('teamTypeUpdated', $teamType);
        $this->emit('refreshTeamTypeTable');
        $this->closeModal();
    }

    public function addTeamType() {
        $this->slug = \Str::slug($this->name);
        $this->validate();

        $teamType = TeamType::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
        ]);

        $this->emit('teamTypeAdded', $teamType);
        $this->emit('refreshTeamTypeTable');
        $this->closeModal();
    }

    public function mount($actionType, TeamType $teamType) {
        $this->actionType = $actionType;

        if ($actionType === 'edit') {
            $this->teamType = $teamType;

            $this->fill([
                'name' => $teamType->name,
                'description' => $teamType->description,
            ]);
        } else if ($actionType === 'add') {
            $faker = \Faker\Factory::create('en_IN');

            $this->fill([
                'name' => $faker->randomElement(['First Responders', 'Incident Commanders', 'Operational', 'Communications', 'Liaison', 'Logistics', 'Medical', 'Search and Rescue', 'Support']),
                'description' => $faker->realText(100),
            ]);
        }
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.modals.edit-team-type-details');
    }
}
