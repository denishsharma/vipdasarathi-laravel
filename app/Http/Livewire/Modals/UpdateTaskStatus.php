<?php

namespace App\Http\Livewire\Modals;

use App\Models\Task;
use LivewireUI\Modal\ModalComponent;

class UpdateTaskStatus extends ModalComponent {
    public $task;
    public $status;

    public static function modalMaxWidth(): string {
        return 'sm';
    }

    public function updateTaskStatus() {
        $this->task->update([
            'status' => $this->status,
        ]);

        $this->emit('taskUpdated');
        $this->closeModal();
    }

    public function mount(Task $task) {
        $this->task = $task;
        $this->status = $task['status'];
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.modals.update-task-status');
    }
}
