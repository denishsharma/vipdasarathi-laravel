<?php

namespace App\Http\Livewire\Modals;

use App\Models\User;
use App\Models\Demand;
use WireUi\Traits\Actions;
use App\Models\DemandType;
use App\Models\DisasterCase;
use LivewireUI\Modal\ModalComponent;

class EditDemandDetails extends ModalComponent {
    use Actions;

    public string $actionType;

    public $subject;
    public $slug;
    public $description;
    public $status;
    public $decision;
    public $demandType;
    public $createdBy;

    public $items = [];
    public $itemName = '';
    public $itemQuantity = 0;

    public $demand;
    public $case;

    protected $rules = [
        'subject' => 'required',
        'description' => 'required',
        'demandType' => 'required',
        'createdBy' => 'required',
        'slug' => 'required|unique:demands',
    ];

    protected $messages = [
        'slug.unique' => 'Demand already exists.',
    ];

    public function addItem() {
        $this->validate([
            'itemName' => 'required',
        ]);

        array_push($this->items, [
            'key' => \Str::slug($this->itemName . ' ' . now()),
            'name' => $this->itemName,
            'quantity' => $this->itemQuantity,
        ]);

        $this->itemName = '';
        $this->itemQuantity = 0;
    }

    public function removeItem($key) {
        $this->items = array_filter($this->items, function ($item) use ($key) {
            return $item['key'] !== $key;
        });
    }

    public function updateDemand() {
        $this->validate([
            'subject' => 'required',
            'description' => 'required',
            'demandType' => 'required',
            'createdBy' => 'required',
        ]);

        $demand = Demand::whereSlug($this->demand->slug)->first();
        $demand->update([
            'subject' => $this->subject,
            'description' => $this->description,
            'demand_type_id' => DemandType::whereSlug($this->demandType)->first()->id,
            'user_id' => User::whereSlug($this->createdBy)->first()->id,
            'status' => $this->status,
            'decision' => $this->decision,
            'items' => $this->items,
        ]);

        $this->emit('caseUpdated');
        $this->emit('caseActivityUpdated');
        $this->emit('demandUpdated', $demand);
        $this->emit('refreshCaseDemandsTable');
        $this->closeModal();
    }

    public function addDemand() {
        $this->slug = \Str::slug($this->subject . ' ' . now());
        $this->validate();

        $demand = $this->case->demands()->create([
            'subject' => $this->subject,
            'description' => $this->description,
            'demand_type_id' => DemandType::whereSlug($this->demandType)->first()->id,
            'user_id' => User::whereSlug($this->createdBy)->first()->id,
            'status' => $this->status,
            'decision' => $this->decision,
            'items' => $this->items,
        ]);

        $this->emit('caseUpdated');
        $this->emit('caseActivityUpdated');
        $this->emit('demandUpdated', $demand);
        $this->emit('refreshCaseDemandsTable');
        $this->closeModal();
    }

    public function mount($actionType, DisasterCase $case, Demand $demand) {
        $this->actionType = $actionType;
        $this->case = $case;

        if ($this->actionType === 'edit' || $this->actionType === 'view' || $this->actionType === 'task') {
            $this->demand = $demand;

            $this->fill([
                'subject' => $demand->subject,
                'description' => $demand->description,
                'demandType' => $demand->demand_type->slug,
                'createdBy' => $demand->user->slug,
                'status' => $demand->status,
                'decision' => $demand->decision,
                'items' => $demand->items,
            ]);
        } else if ($this->actionType === 'add') {
            $faker = \Faker\Factory::create();

            $this->fill([
                'subject' => $faker->sentence(5),
                'description' => $faker->paragraph(3),
                'demandType' => DemandType::all()->random()->slug,
                'createdBy' => auth()->user()->slug,
            ]);
        }
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.modals.edit-demand-details');
    }
}
