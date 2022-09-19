<?php

namespace App\Http\Livewire\Modals;

use App\Models\User;
use App\Models\Task;
use App\Models\Ticket;
use App\Models\TaskType;
use App\Models\Attachment;
use WireUi\Traits\Actions;
use App\Models\DisasterCase;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Storage;

class EditTicketDetails extends ModalComponent {
    use WithFileUploads, Actions;

    public string $actionType;

    public $subject;
    public $slug;
    public $description;
    public $issuedBy;
    public $status;

    public $attachments = [];
    public $oldAttachments = [];

    public $ticket;
    public $case;
    public $task;

    protected $rules = [
        'subject' => 'required',
        'description' => 'required',
        'issuedBy' => 'required',
        'slug' => 'required|unique:tickets',
    ];

    protected $messages = [
        'slug.unique' => 'Ticket already exists.',
    ];

    public function clearAttachments() {
        $this->reset('attachments');
    }

    public function downloadAttachment(Attachment $attachment): \Symfony\Component\HttpFoundation\StreamedResponse {
        return Storage::disk('public')->download('attachments/' . $attachment->filename, $attachment->original_filename);
    }

    public function removeAttachment(Attachment $attachment) {
        $this->ticket->attachments()->where('id', $attachment->id)->delete();
        $this->oldAttachments = $this->ticket->attachments()->get();

        Storage::delete('public/attachments/' . $attachment->filename);

        $this->emit('ticketUpdated', $this->ticket);
        $this->emit('refreshCaseTicketsTable');
    }

    public function updateTicket() {
        $this->validate([
            'subject' => 'required',
            'issuedBy' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        $ticket = Ticket::whereSlug($this->ticket->slug)->firstOrFail();
        $ticket->update([
            'subject' => $this->subject,
            'description' => $this->description,
            'user_id' => User::whereSlug($this->issuedBy)->first()->id,
            'status' => $this->status,
        ]);

        $this->sync_attachments_and_emit($ticket);
    }

    public function updateTicketStatus() {
        $this->validate([
            'status' => 'required',
        ]);

        $ticket = Ticket::whereSlug($this->ticket->slug)->firstOrFail();
        $ticket->update([
            'status' => $this->status,
        ]);

        $this->notification()->success(
            'Ticket status updated successfully.',
            "Ticket status updated to {$this->ticket->status()}."
        );

        $this->emit('ticketUpdated', $ticket);
        $this->emit('taskUpdated', $this->task);
        $this->emit('refreshCaseTicketsTable');
        $this->emit('refreshCaseTasksTable');
        $this->closeModal();
    }

    public function addTicket() {
        $this->slug = \Str::slug($this->subject . ' ' . now());
        $this->validate();

        $ticket = $this->task->tickets()->create([
            'slug' => $this->slug,
            'subject' => $this->subject,
            'description' => $this->description,
            'user_id' => User::whereSlug($this->issuedBy)->firstOrFail()->id,
            'disaster_case_id' => $this->case['id'],
        ]);

        $this->sync_attachments_and_emit($ticket);
    }

    public function createTicketTask() {
        $taskType = TaskType::inRandomOrder()->first()->id;
        $priority = 'high';
        $taskCategory = 'tickets';
        $taskSlug = \Str::slug($this->subject . ' ' . $taskType . ' ' . $priority . ' ' . $taskCategory);

        $task = Task::create([
            'slug' => $taskSlug,
            'subject' => $this->subject,
            'description' => $this->description,
            'task_type_id' => $taskType,
            'priority' => $priority,
            'task_category' => $taskCategory,
            'disaster_case_id' => $this->ticket->disaster_case()->first()->id,
            'task_of_id' => $this->ticket['id'],
        ]);

        $ticket = Ticket::whereSlug($this->ticket->slug)->firstOrFail();
        $ticket->update([
            'task_id' => $task->id,
            'status' => 'task',
        ]);

        $this->emit('taskUpdated', $this->task);
        $this->emit('refreshCaseTicketsTable');
        $this->emit('refreshCaseTasksTable');
        $this->closeModal();
    }

    public function mount($actionType, DisasterCase $case, Task $task, Ticket $ticket) {
        $this->actionType = $actionType;
        $this->case = $case;
        $this->task = $task;

        if ($this->actionType == 'edit' || $this->actionType == 'view' || $this->actionType == 'task') {
            $this->ticket = $ticket;

            $this->fill([
                'subject' => $ticket->subject,
                'description' => $ticket->description,
                'issuedBy' => $ticket->user->slug,
                'oldAttachments' => $ticket->attachments,
                'status' => $ticket->status == 'closed' ? 'closed' : 'open',
            ]);
        } else if ($this->actionType == 'add') {
            $faker = \Faker\Factory::create();

            $this->fill([
                'subject' => $faker->sentence(5),
                'description' => $faker->paragraph(3),
                'issuedBy' => User::inRandomOrder()->first()->slug,
            ]);
        }
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.modals.edit-ticket-details');
    }

    /**
     * @param $ticket
     *
     * @return void
     */
    public function sync_attachments_and_emit($ticket): void {
        if (!empty($this->attachments)) {
            foreach ($this->attachments as $attachment) {
                $attachment->store('attachments', 'public');
                $ticket->attachments()->create([
                    'slug' => \Str::slug($attachment->getClientOriginalName() . ' ' . now()),
                    'filename' => $attachment->hashName(),
                    'original_filename' => $attachment->getClientOriginalName(),
                ]);
            }
        }

        $this->emit('ticketUpdated', $ticket);
        $this->emit('taskUpdated', $this->task);
        $this->emit('refreshCaseTicketsTable');
        $this->emit('refreshCaseTasksTable');
        $this->closeModal();
    }
}
