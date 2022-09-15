<?php

namespace App\Http\Livewire\Modals;

use App\Models\DisasterType;
use LivewireUI\Modal\ModalComponent;

class EditDisasterTypeDetails extends ModalComponent {
    public string $actionType;

    public $name;
    public $slug;

    public $disasterType;

    protected $rules = [
        'name' => 'required',
        'slug' => 'required|unique:disaster_types',
    ];

    protected $messages = [
        'slug.unique' => 'Disaster type already exists.',
    ];

    public function updateDisasterType() {
        $this->validate([
            'name' => 'required',
        ]);

        $disasterType = DisasterType::whereSlug($this->disasterType->slug)->firstOrFail();
        $disasterType->update([
            'name' => $this->name,
        ]);

        $this->emit('disasterTypeUpdated', $disasterType);
        $this->emit('refreshDisasterTypeTable');
        $this->closeModal();
    }

    public function addDisasterType() {
        $this->slug = \Str::slug($this->name);
        $this->validate();

        $disasterType = DisasterType::create([
            'name' => $this->name,
            'slug' => $this->slug,
        ]);

        $this->emit('disasterTypeAdded', $disasterType);
        $this->emit('refreshDisasterTypeTable');
        $this->closeModal();
    }

    public function mount($actionType, DisasterType $disasterType) {
        $this->actionType = $actionType;

        if ($actionType === 'edit') {
            $this->disasterType = $disasterType;

            $this->fill([
                'name' => $disasterType->name,
            ]);
        } else if ($actionType === 'add') {
            $faker = \Faker\Factory::create('en_IN');

            $this->fill([
                'name' => $faker->randomElement(['Earthquake', 'Flood', 'Fire', 'Landslide', 'Tsunami', 'Volcano']),
            ]);
        }
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.modals.edit-disaster-type-details');
    }
}
