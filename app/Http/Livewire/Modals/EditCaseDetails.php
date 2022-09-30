<?php

namespace App\Http\Livewire\Modals;

use Carbon\Carbon;
use App\Models\DisasterCase;
use App\Models\DisasterType;
use LivewireUI\Modal\ModalComponent;

class EditCaseDetails extends ModalComponent {
    public string $actionType;

    public $title;
    public $description;
    public $addressLine;
    public $zipcode;
    public $city;
    public $district;
    public $state;
    public $disasterType;
    public $selectedSop;
    public $priority;
    public $happenedAt;
    public $slug;

    public $case;

    protected $rules = [
        'title' => 'required',
        'addressLine' => 'required',
        'zipcode' => 'required',
        'city' => 'required',
        'district' => 'required',
        'state' => 'required',
        'disasterType' => 'required',
        'priority' => 'required',
        'happenedAt' => 'required',
        'slug' => 'required|unique:disaster_cases',
    ];

    protected $messages = [
        'slug.unique' => 'Case already exists.',
    ];

    public function updateCase() {
        $this->validate([
            'title' => 'required',
            'addressLine' => 'required',
            'zipcode' => 'required',
            'city' => 'required',
            'district' => 'required',
            'state' => 'required',
            'disasterType' => 'required',
            'priority' => 'required',
            'happenedAt' => 'required',
        ]);

        $case = DisasterCase::whereSlug($this->case->slug)->firstOrFail();

        $caseAddress = $case->address();
        $caseAddress->update([
            'address_line_1' => $this->addressLine,
            'zipcode' => $this->zipcode,
            'city' => $this->city,
            'district' => $this->district,
            'state_id' => $this->state,
        ]);

        $case->update([
            'title' => $this->title,
            'description' => $this->description,
            'disaster_type_id' => DisasterType::whereSlug($this->disasterType)->firstOrFail()->id,
            'priority' => $this->priority,
            'happened_at' => $this->happenedAt,
        ]);

        $case->activities()->create([
            'slug' => now(),
            'subject' => 'Case Details Updated',
            'description' => 'Case details updated by ' . auth()->user()->full_name(),
            'user_id' => auth()->user()->id,
            'activity_category' => 'details',
        ]);

        $this->emit('caseUpdated', $case);
        $this->emit('refreshCaseTable');
        $this->emit('caseActivityUpdated');
        $this->closeModal();
    }

    public function addCase() {
        $this->slug = \Str::slug($this->title . ' ' . $this->disasterType . ' ' . $this->happenedAt);
        $this->validate();

        $case = DisasterCase::create([
            'title' => $this->title,
            'description' => $this->description,
            'disaster_type_id' => DisasterType::whereSlug($this->disasterType)->firstOrFail()->id,
            'priority' => $this->priority,
            'happened_at' => Carbon::parse($this->happenedAt),
            'slug' => $this->slug,
        ]);

        $case->address()->create([
            'address_line_1' => $this->addressLine,
            'zipcode' => $this->zipcode,
            'city' => $this->city,
            'district' => $this->district,
            'state_id' => $this->state,
        ]);

        $case->disaster_case_metadata()->create([
            'slug' => now(),
            'casualties' => json_encode([
                'total' => 0,
                'deaths' => 0,
                'rescued' => 0,
                'injured' => 0,
                'missing' => 0,
            ]),
        ]);

        $this->emit('caseAdded', $case);
        $this->emit('refreshCaseTable');
        $this->closeModal();
    }

    public function mount($actionType, DisasterCase $case) {
        $this->actionType = $actionType;

        if ($actionType === 'edit') {
            $this->case = $case;

            $this->fill([
                'title' => $case->title,
                'description' => $case->description,
                'addressLine' => $case->address->address_line_1,
                'zipcode' => $case->address->zipcode,
                'city' => $case->address->city,
                'district' => $case->address->district,
                'state' => $case->address->state_id,
                'disasterType' => $case->disaster_type->slug,
                'priority' => $case->priority,
                'happenedAt' => $case->happened_at,
            ]);
        } else if ($actionType === 'add') {
            $faker = \Faker\Factory::create('en_IN');

            $this->fill([
                'title' => $faker->sentence(3),
                'description' => $faker->paragraph(3),
                'addressLine' => $faker->streetAddress,
                'zipcode' => $faker->postcode,
                'city' => $faker->city,
                'district' => $faker->city,
                'state' => '22',
                'disasterType' => DisasterType::first()->slug,
                'priority' => 'urgent',
                'happenedAt' => $faker->dateTimeBetween('-1 years')->format('Y-m-d H:i:s'),
            ]);
        }
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.modals.edit-case-details');
    }
}
