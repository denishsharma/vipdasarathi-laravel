<?php

namespace App\Http\Livewire\Tables\Case;

use Livewire\Component;

class CaseActivitiesSingleTable extends Component {
    public $case;

    public $activities = [];

    protected $listeners = [
        'caseUpdated' => 'refreshData',
        'taskUpdated' => 'refreshData',
        'caseActivityUpdated' => 'refreshData',
    ];

    public function refreshData() {
        $this->case = $this->case->fresh();

        $this->activities = $this->case->activities()->orderByDesc('created_at')->get();
        $this->case->tasks()->each(function ($task) {
            $this->activities = $this->activities->merge($task->activities()->orderByDesc('created_at')->get()->map(function ($activity) use ($task) {
                $activity->description = '<div>' . $activity->description . '</div><div class="mt-1"><i><span class="font-medium">Task:</span> ' . $task->subject . '</i></div>';
                $activity->actions = [
                    [
                        'label' => 'View Task',
                        'url' => route('task.view.overview', $task->slug),
                    ],
                ];
                return $activity;
            }));
        });

        $this->activities = $this->activities->sortByDesc('created_at');
    }

    public function mount() {
        $this->refreshData();
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.tables.case.case-activities-single-table');
    }
}
