<?php

namespace App\Http\Livewire\Modals;

use App\Models\User;
use App\Models\Task;
use App\Models\Activity;
use App\Models\Attachment;
use App\Models\ActivityType;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Storage;

class EditTaskUpdateDetails extends ModalComponent {
    use WithFileUploads;

    public string $actionType;

    public $subject;
    public $slug;
    public $description;
    public $activityType;
    public $updateBy;
    public $activityCategory;

    public $attachments = [];

    public $activity;
    public $task;

    protected $rules = [
        'subject' => 'required',
        'activityType' => 'required',
        'updateBy' => 'required',
        'activityCategory' => 'required',
        'slug' => 'required|unique:activities',
    ];

    protected $messages = [
        'slug.unique' => 'Activity already exists.',
    ];

    public function clearAttachments() {
        $this->reset('attachments');
    }

    public function removeAttachment(Attachment $attachment) {
        $this->activity->attachments()->where('id', $attachment->id)->delete();
        $this->attachments = $this->activity->attachments()->get();

        Storage::delete('public/attachments/' . $attachment->filename);

        $this->emit('taskUpdated', $this->task);
    }

    public function addTaskUpdate() {
        $this->slug = $this->subject . now();
        $this->validate();

        $activity = $this->task->activities()->create([
            'slug' => $this->slug,
            'subject' => $this->subject,
            'description' => $this->description,
            'activity_type_id' => ActivityType::whereSlug($this->activityType)->first()->id,
            'user_id' => User::whereSlug($this->updateBy)->first()->id,
            'activity_category' => $this->activityCategory,
        ]);

        if (!empty($this->attachments)) {
            foreach ($this->attachments as $attachment) {
                $attachment->store('attachments', 'public');
                $activity->attachments()->create([
                    'slug' => \Str::slug($attachment->getClientOriginalName() . ' ' . now()),
                    'filename' => $attachment->hashName(),
                    'original_filename' => $attachment->getClientOriginalName(),
                ]);
            }
        }

        $this->emit('taskUpdated', $this->task);
        $this->closeModal();
    }

    public function mount($actionType, Task $task) {
        $this->task = $task;

        if ($actionType == 'add') {
            $faker = \Faker\Factory::create('en_IN');

            $randomActivityType = ActivityType::inRandomOrder()->first();

            $this->fill([
                'subject' => $faker->sentence(5),
                'description' => $faker->paragraph(5),
                'activityType' => $randomActivityType->slug,
                'updateBy' => auth()->user()->slug,
                'activityCategory' => 'comment',
            ]);
        }
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.modals.edit-task-update-details');
    }
}
