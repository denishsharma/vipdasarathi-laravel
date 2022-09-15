<?php

namespace App\Http\Livewire\Modals;

use App\Models\Team;
use App\Models\User;
use App\Models\TeamType;
use LivewireUI\Modal\ModalComponent;

class EditTeamDetails extends ModalComponent {
    public string $actionType;

    public $name;
    public $slug;
    public $description;
    public $teamType;
    public $members = [];
    public $users = [];

    public $team;

    protected $rules = [
        'name' => 'required',
        'teamType' => 'required',
        'slug' => 'required|unique:teams',
    ];

    protected $messages = [
        'slug.unique' => 'Team already exists.',
    ];

    public function updateTeam() {
        $this->validate([
            'name' => 'required',
            'teamType' => 'required',
        ]);

        $team = Team::whereSlug($this->team->slug)->firstOrFail();
        $team->update([
            'name' => $this->name,
            'team_type_id' => TeamType::whereSlug($this->teamType)->firstOrFail()->id,
            'description' => $this->description,
        ]);

        $team->users()->sync($this->users->pluck('id'));

        $this->emit('teamUpdated', $team);
        $this->emit('refreshTeamTable');
        $this->closeModal();
    }

    public function updateTeamMembers() {
        $team = Team::whereSlug($this->team->slug)->firstOrFail();
        $team->users()->sync($this->users->pluck('id'));

        $this->emit('teamUpdated', $team);
        $this->emit('refreshTeamTable');
        $this->closeModal();
    }

    public function addTeam() {
        $this->slug = \Str::slug($this->name . ' ' . $this->teamType);
        $this->validate();

        $team = Team::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'team_type_id' => TeamType::whereSlug($this->teamType)->firstOrFail()->id,
            'description' => $this->description,
        ]);

        $team->users()->attach($this->users->pluck('id'));

        $this->emit('teamAdded', $team);
        $this->emit('refreshTeamTable');
        $this->closeModal();
    }

    public function updatedMembers() {
        $this->users = User::with('organization')->whereIn('slug', $this->members)->get();
    }

    public function mount($actionType, Team $team) {
        $this->actionType = $actionType;

        if ($actionType === 'edit') {
            $this->team = $team;

            $this->fill([
                'name' => $team->name,
                'slug' => $team->slug,
                'description' => $team->description,
                'teamType' => $team->team_type->slug,
                'members' => $team->users->pluck('slug')->toArray(),
                'users' => $team->users,
            ]);
        } else if ($actionType === 'add') {
            $faker = \Faker\Factory::create('en_IN');

            $randomUsers = User::inRandomOrder()->limit(5)->get();

            $this->fill([
                'name' => $faker->company,
                'description' => $faker->realText(60),
                'teamType' => TeamType::all()->random()->slug,
                'members' => $randomUsers->pluck('slug')->toArray(),
                'users' => $randomUsers,
            ]);
        } else if ($actionType === 'manage-members') {
            $this->team = $team;

            $this->fill([
                'members' => $team->users->pluck('slug')->toArray(),
                'users' => $team->users,
            ]);
        }
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.modals.edit-team-details');
    }
}
