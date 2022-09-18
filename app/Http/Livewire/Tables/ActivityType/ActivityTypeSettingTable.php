<?php

namespace App\Http\Livewire\Tables\ActivityType;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\ActivityType;

class ActivityTypeSettingTable extends Component {
    use Actions;

    public $description;
    public $currentTab = 'active';

    public $activityTypes = [];

    protected $listeners = [
        'refreshActivityTypeTable' => 'refreshTable',
        'activityTypeChangeTab' => 'changeTab',
    ];

    public function refreshTable($archived = false) {
        if ($archived || $this->currentTab == 'archived') {
            $this->activityTypes = ActivityType::onlyTrashed()->orderByDesc('created_at')->get();
        } else {
            $this->activityTypes = ActivityType::orderByDesc('created_at')->get();
        }
    }

    public function changeTab($tab) {
        $this->currentTab = $tab;

        if ($tab == 'archived') {
            $this->description = 'Here you will find all the archived/deleted activity types. You can restore the deleted activity types from here.';
            $this->refreshTable(true);
        } else {
            $this->description = 'Here you will find all the activity types at once place. Manage and view cases as per types.';
            $this->refreshTable();
        }
    }

    public function openEditModal($activityType) {
        $this->emit('openModal', 'modals.edit-activity-type-details', [
            'actionType' => 'edit',
            'activityType' => $activityType,
        ]);
    }

    public function mount() {
        $this->refreshTable();
    }

    public function openDeleteModal($activityType) {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Delete the Activity Type?',
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, delete it',
                'method' => 'deleteActivityType',
                'params' => $activityType,
                'color' => 'negative',
            ],
            'cancel' => [
                'label' => 'No, cancel it',
            ],
        ]);
    }

    public function openRestoreModal($activityType) {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Restore the Activity Type?',
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, restore it',
                'method' => 'restoreActivityType',
                'params' => $activityType,
                'color' => 'positive',
            ],
            'cancel' => [
                'label' => 'No, cancel it',
            ],
        ]);
    }

    public function deleteActivityType($activityType) {
        $activityType = ActivityType::whereSlug($activityType['slug'])->firstOrFail();

        if ($activityType->activities_count > 0) {
            $this->notification()->error(
                'Error',
                'You cannot delete this activity type because it is being used by some activities.',
            );
        } else {
            $activityType->delete();

            $this->emit('refreshActivityTypeTable');

            $this->notification()->success(
                'Success',
                'Activity Type deleted successfully.',
            );
        }

        $this->refreshTable();
    }

    public function restoreActivityType($activityType) {
        $activityType = ActivityType::onlyTrashed()->whereSlug($activityType['slug'])->withTrashed()->firstOrFail();

        $activityType->restore();

        $this->emit('refreshActivityTypeTable');

        $this->notification()->success(
            'Success',
            'Activity Type restored successfully.',
        );
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.tables.activity-type.activity-type-setting-table');
    }
}
