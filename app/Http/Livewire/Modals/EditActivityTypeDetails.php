<?php

namespace App\Http\Livewire\Modals;

use App\Models\ActivityType;
use LivewireUI\Modal\ModalComponent;

class EditActivityTypeDetails extends ModalComponent {
    public string $actionType;

    public $name;
    public $slug;

    public $activityType;

    protected $rules = [
        'name' => 'required',
        'slug' => 'required|unique:activity_types',
    ];

    protected $messages = [
        'slug.unique' => 'Activity type already exists.',
    ];

    public function updateActivityType() {
        $this->validate([
            'name' => 'required',
        ]);

        $activityType = ActivityType::whereSlug($this->activityType->slug)->firstOrFail();
        $activityType->update([
            'name' => $this->name,
        ]);

        $this->emit('activityTypeUpdated', $activityType);
        $this->emit('refreshActivityTypeTable');
        $this->closeModal();
    }

    public function addActivityType() {
        $this->slug = \Str::slug($this->name);
        $this->validate();

        $activityType = ActivityType::create([
            'name' => $this->name,
            'slug' => $this->slug,
        ]);

        $this->emit('activityTypeAdded', $activityType);
        $this->emit('refreshActivityTypeTable');
        $this->closeModal();
    }

    public function mount($actionType, ActivityType $activityType) {
        $this->actionType = $actionType;

        if ($actionType === 'edit') {
            $this->activityType = $activityType;

            $this->fill([
                'name' => $activityType->name,
            ]);
        } else if ($actionType === 'add') {
            $faker = \Faker\Factory::create('en_IN');

            $this->fill([
                'name' => $faker->randomElement(['Resource Update', 'Comment Update', 'Status Update', 'Information Update']),
            ]);
        }
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.modals.edit-activity-type-details');
    }
}
