<?php

namespace App\Http\Livewire\Modals;

use App\Models\Task;
use App\Models\Team;
use App\Models\TaskType;
use App\Models\Attachment;
use App\Models\DisasterCase;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Storage;

class EditTaskDetails extends ModalComponent {
    use WithFileUploads;

    public string $actionType;

    public $subject;
    public $slug;
    public $description;
    public $taskType;
    public $priority;
    public $taskCategory;

    public $teamSlugs = [];
    public $teams = [];

    public $attachments = [];
    public $oldAttachments = [];

    public $task;
    public $case;

    protected $rules = [
        'subject' => 'required',
        'taskType' => 'required',
        'priority' => 'required',
        'teams' => 'required|min:1',
        'slug' => 'required|unique:tasks',
    ];

    protected $messages = [
        'slug.unique' => 'Task already exists.',
    ];

    public function clearAttachments() {
        $this->reset('attachments');
    }

    public function removeAttachment(Attachment $attachment) {
        $this->task->attachments()->where('id', $attachment->id)->delete();
        $this->oldAttachments = $this->task->attachments()->get();

        Storage::delete('public/attachments/' . $attachment->filename);

        $this->emit('taskUpdated', $this->task);
        $this->emit('refreshCaseTasksTable');
    }

    public function updatedTeamSlugs() {
        $this->teams = Team::whereIn('slug', $this->teamSlugs)->get();
    }

    public function updateTask() {
        $this->validate([
            'subject' => 'required',
            'taskType' => 'required',
            'priority' => 'required',
            'teams' => 'required|min:1',
        ]);

        $task = Task::whereSlug($this->task->slug)->firstOrFail();
        $task->update([
            'subject' => $this->subject,
            'task_type_id' => TaskType::whereSlug($this->taskType)->firstOrFail()->id,
            'description' => $this->description,
            'priority' => $this->priority,
        ]);

        $this->sync_team_and_attachments($task);

        $this->emit('taskUpdated', $task);
        $this->emit('refreshCaseTasksTable');
        $this->closeModal();
    }

    public function addTask() {
        $this->slug = \Str::slug($this->subject . ' ' . $this->taskType . ' ' . $this->priority . ' ' . $this->taskCategory);
        $this->validate();

        $task = Task::create([
            'slug' => $this->slug,
            'subject' => $this->subject,
            'description' => $this->description,
            'priority' => $this->priority,
            'disaster_case_id' => $this->case['id'],
            'task_type_id' => TaskType::whereSlug($this->taskType)->firstOrFail()->id,
            'task_category' => $this->taskCategory,
        ]);

        $this->sync_team_and_attachments($task);

        $this->emit('taskAdded', $task);
        $this->emit('refreshCaseTasksTable');
        $this->closeModal();
    }

    public function mount($actionType, Task $task, DisasterCase $case) {
        $this->actionType = $actionType;

        if ($actionType === 'edit' || $actionType === 'manage-teams' || $actionType === 'manage-attachments') {
            $this->task = $task;
            $this->case = $case;

            $this->fill([
                'subject' => $task->subject,
                'slug' => $task->slug,
                'description' => $task->description,
                'taskType' => $task->task_type->slug,
                'priority' => $task->priority,
                'taskCategory' => $task->task_category,
                'teams' => $task->teams,
                'teamSlugs' => $task->teams->pluck('slug'),
                'oldAttachments' => $task->attachments,
            ]);

        } else if ($actionType === 'add') {
            $faker = \Faker\Factory::create('en_IN');

            $randomTeams = Team::inRandomOrder()->limit(2)->get();

            $this->fill([
                'subject' => $faker->sentence(4),
                'description' => $faker->paragraph(3),
                'taskType' => TaskType::inRandomOrder()->first()->slug,
                'priority' => $faker->randomElement(['low', 'medium', 'high']),
                'teamSlugs' => $randomTeams->pluck('slug'),
                'teams' => $randomTeams,
            ]);
        }
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.modals.edit-task-details');
    }

    /**
     * @param Task $task
     *
     * @return void
     */
    public function sync_team_and_attachments(Task $task): void {
        $task->teams()->sync($this->teams->pluck('id'));
        $case = DisasterCase::whereSlug($this->case['slug'])->firstOrFail();
        $case->teams()->sync($this->teams->pluck('id'), false);

        if (!empty($this->attachments)) {
            foreach ($this->attachments as $attachment) {
                $attachment->store('attachments', 'public');
                $task->attachments()->create([
                    'slug' => \Str::slug($attachment->getClientOriginalName() . ' ' . now()),
                    'filename' => $attachment->hashName(),
                    'original_filename' => $attachment->getClientOriginalName(),
                ]);
            }
        }
    }
}
