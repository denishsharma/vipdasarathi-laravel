<?php

namespace App\Http\Livewire\Modals;

use App\Models\DemandType;
use LivewireUI\Modal\ModalComponent;

class EditDemandTypeDetails extends ModalComponent {
    public string $actionType;

    public $name;
    public $slug;

    public $demandType;

    protected $rules = [
        'name' => 'required',
        'slug' => 'required|unique:demand_types',
    ];

    protected $messages = [
        'slug.unique' => 'Demand type already exists.',
    ];

    public function updateDemandType() {
        $this->validate([
            'name' => 'required',
        ]);

        $demandType = DemandType::whereSlug($this->demandType->slug)->firstOrFail();
        $demandType->update([
            'name' => $this->name,
        ]);

        $this->emit('demandTypeUpdated', $demandType);
        $this->emit('refreshDemandTypeTable');
        $this->closeModal();
    }

    public function addDemandType() {
        $this->slug = \Str::slug($this->name);
        $this->validate();

        $demandType = DemandType::create([
            'name' => $this->name,
            'slug' => $this->slug,
        ]);

        $this->emit('demandTypeAdded', $demandType);
        $this->emit('refreshDemandTypeTable');
        $this->closeModal();
    }

    public function mount($actionType, DemandType $demandType) {
        $this->actionType = $actionType;

        if ($actionType === 'edit') {
            $this->demandType = $demandType;

            $this->fill([
                'name' => $demandType->name,
            ]);
        } else if ($actionType === 'add') {
            $faker = \Faker\Factory::create('en_IN');

            $this->fill([
                'name' => $faker->randomElement(['Resource Demand', 'Manpower Demand', 'Information Demand']),
            ]);
        }
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.modals.edit-demand-type-details');
    }
}
