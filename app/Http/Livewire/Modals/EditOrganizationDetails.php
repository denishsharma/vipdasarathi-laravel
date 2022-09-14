<?php

namespace App\Http\Livewire\Modals;

use App\Models\Organization;
use LivewireUI\Modal\ModalComponent;

class EditOrganizationDetails extends ModalComponent {
    public string $actionType;

    public $name;
    public $level;
    public $slug;
    public $description;

    public $organization;

    protected $rules = [
        'name' => 'required',
        'level' => 'required',
        'slug' => 'required|unique:organizations',
    ];

    protected $messages = [
        'slug.unique' => 'Organization already exists.',
    ];

    public function updateOrganization() {
        $this->validate([
            'name' => 'required',
            'level' => 'required',
        ]);

        $organization = Organization::whereSlug($this->organization->slug)->firstOrFail();
        $organization->update([
            'name' => $this->name,
            'level' => $this->level,
            'description' => $this->description,
        ]);

        $this->emit('organizationUpdated', $organization);
        $this->emitTo('tables.organization.organization-setting-table', 'refreshTable');
        $this->closeModal();
    }

    public function addOrganization() {
        $this->slug = \Str::slug($this->name . ' ' . $this->level);
        $this->validate();

        $organization = Organization::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'level' => $this->level,
            'description' => $this->description,
        ]);

        $this->emit('organizationAdded', $organization);
        $this->emit('refreshOrganizationTable');
        $this->closeModal();
    }

    public function mount(string $actionType, Organization $organization) {
        if ($actionType === 'edit') {
            $this->actionType = 'edit';
            $this->organization = $organization;


            $this->fill([
                'name' => $organization->name,
                'level' => $organization->level,
                'description' => $organization->description,
            ]);

        } else if ($actionType === 'add') {
            $this->actionType = 'add';
            $faker = \Faker\Factory::create('en_IN');

            $this->fill([
                'name' => $faker->randomElement(['NDRF', 'NDMA', 'NIDM', 'EOC', 'MHA']),
                'level' => 'national',
                'description' => $faker->text(200),
            ]);
        }
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.modals.edit-organization-details');
    }
}
