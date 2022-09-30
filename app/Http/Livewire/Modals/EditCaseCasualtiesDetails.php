<?php

namespace App\Http\Livewire\Modals;

use App\Models\DisasterCase;
use LivewireUI\Modal\ModalComponent;

class EditCaseCasualtiesDetails extends ModalComponent {
    public $deathCount = 0;
    public $rescuedCount = 0;
    public $injuredCount = 0;
    public $missingCount = 0;

    public $case;

    protected $messages = [
        'injuredCount.max' => 'Injured count cannot be greater than rescued count.',
    ];

    public function updateCasualties() {
        $this->validate([
            'deathCount' => 'required|numeric|min:0',
            'rescuedCount' => 'required|numeric|min:0',
            'injuredCount' => 'required|numeric|min:0|max:' . $this->rescuedCount,
            'missingCount' => 'required|numeric|min:0',
        ]);

        $case = DisasterCase::whereSlug($this->case->slug)->firstOrFail();
        $case->disaster_case_metadata()->update([
            'casualties' => json_encode([
                'deaths' => $this->deathCount,
                'rescued' => $this->rescuedCount,
                'injured' => $this->injuredCount,
                'missing' => $this->missingCount,
            ]),
        ]);

        $case->activities()->create([
            'slug' => now(),
            'subject' => 'Case Casualties Updated',
            'description' => 'case casualties updated with <span class="font-medium">total of ' . $this->deathCount + $this->rescuedCount . ' victims</span> form which <span class="font-medium">' . $this->deathCount . ' are dead </span> and <span class="font-medium">' . $this->rescuedCount . ' rescued </span> in which <span class="font-medium">' . $this->injuredCount . ' injured</span> and <span class="font-medium">' . $this->missingCount . ' are missing</span>.',
            'user_id' => auth()->user()->id,
            'activity_category' => 'details',
        ]);

        $this->emit('caseUpdated', $case);
        $this->emit('caseActionUpdated');
        $this->closeModal();
    }

    public function mount(DisasterCase $case) {
        $this->case = $case;

        $this->deathCount = $case->disaster_case_metadata->get_casualties()['deaths'];
        $this->rescuedCount = $case->disaster_case_metadata->get_casualties()['rescued'];
        $this->injuredCount = $case->disaster_case_metadata->get_casualties()['injured'];
        $this->missingCount = $case->disaster_case_metadata->get_casualties()['missing'];
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.modals.edit-case-casualties-details');
    }
}
