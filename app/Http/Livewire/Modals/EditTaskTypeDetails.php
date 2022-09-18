<?php

namespace App\Http\Livewire\Modals;

use App\Models\TaskType;
use LivewireUI\Modal\ModalComponent;

class EditTaskTypeDetails extends ModalComponent {
    public string $actionType;

    public $name;
    public $slug;

    public $taskType;

    protected $rules = [
        'name' => 'required',
        'slug' => 'required|unique:task_types',
    ];

    protected $messages = [
        'slug.unique' => 'Task type already exists.',
    ];

    public function updateTaskType() {
        $this->validate([
            'name' => 'required',
        ]);

        $taskType = TaskType::whereSlug($this->taskType->slug)->firstOrFail();
        $taskType->update([
            'name' => $this->name,
        ]);

        $this->emit('taskTypeUpdated', $taskType);
        $this->emit('refreshTaskTypeTable');
        $this->closeModal();
    }

    public function addTaskType() {
        $this->slug = \Str::slug($this->name);
        $this->validate();

        $taskType = TaskType::create([
            'name' => $this->name,
            'slug' => $this->slug,
        ]);

        $this->emit('taskTypeAdded', $taskType);
        $this->emit('refreshTaskTypeTable');
        $this->closeModal();
    }

    public function mount($actionType, TaskType $taskType) {
        $this->actionType = $actionType;

        if ($actionType === 'edit') {
            $this->taskType = $taskType;

            $this->fill([
                'name' => $taskType->name,
            ]);
        } else if ($actionType === 'add') {
            $faker = \Faker\Factory::create('en_IN');

            $this->fill([
                'name' => $faker->randomElement(['Supplies', 'Operational', 'Logistics', 'Medical', 'Security', 'Other']),
            ]);
        }
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.modals.edit-task-type-details');
    }
}
