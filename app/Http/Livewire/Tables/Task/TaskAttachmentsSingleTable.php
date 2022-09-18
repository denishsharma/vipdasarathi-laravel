<?php

namespace App\Http\Livewire\Tables\Task;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class TaskAttachmentsSingleTable extends Component {
    public $task;

    protected $listeners = [
        'taskUpdated' => 'refreshData',
    ];

    public function refreshData() {
        $this->task = $this->task->fresh();
    }

    public function downloadAttachment($attachment): \Symfony\Component\HttpFoundation\StreamedResponse {
        return Storage::disk('public')->download('attachments/' . $attachment['filename'], $attachment['original_filename']);
    }

    public function mount() {
        $this->refreshData();
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.tables.task.task-attachments-single-table');
    }
}
