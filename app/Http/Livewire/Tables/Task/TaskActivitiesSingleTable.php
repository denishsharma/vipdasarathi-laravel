<?php

namespace App\Http\Livewire\Tables\Task;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class TaskActivitiesSingleTable extends Component {
    public $task;

    public $activities = [];

    public $currentCategory = 'all';

    protected $listeners = [
        'taskUpdated' => 'refreshData',
    ];

    public function refreshData() {
        $this->task = $this->task->fresh();

        if ($this->currentCategory === 'all') {
            $this->activities = $this->task->activities()->orderByDesc('created_at')->get();
        } else {
            $this->activities = $this->task->activities()->where('activity_category', $this->currentCategory)->orderByDesc('created_at')->get();
        }
    }

    public function changeCategory($category) {
        $this->currentCategory = $category;
        $this->refreshData();
    }

    public function downloadAttachment($attachment): \Symfony\Component\HttpFoundation\StreamedResponse {
        return Storage::disk('public')->download('attachments/' . $attachment['filename'], $attachment['original_filename']);
    }

    public function mount() {
        $this->refreshData();
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.tables.task.task-activities-single-table');
    }
}
