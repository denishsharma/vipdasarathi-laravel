<?php

namespace App\Http\Livewire\Tables\User;

use App\Models\User;
use Livewire\Component;
use WireUi\Traits\Actions;

class UserSettingTable extends Component {
    use Actions;

    public $description;
    public $currentTab = 'active';

    public $users = [];

    protected $listeners = [
        'refreshUserTable' => 'refreshTable',
        'userChangeTab' => 'changeTab',
    ];

    public function refreshTable($archived = false) {
        if ($archived || $this->currentTab == 'archived') {
            $this->users = User::with('organization', 'user_profile')->onlyTrashed()->whereStatus('archived')->orderByDesc('created_at')->get();
        } else {
            $this->users = User::with('organization', 'user_profile')->orderByDesc('created_at')->get();
        }
    }

    public function changeTab($tab) {
        $this->currentTab = $tab;
        if ($tab == 'archived') {
            $this->description = 'Here you will find all the archived/deleted users. You can restore the deleted users from here.';
            $this->refreshTable(true);
        } else {
            $this->refreshTable();
        }
    }

    public function openEditModal($user) {
        $this->emit('openModal', 'modals.edit-user-details', [
            'actionType' => 'edit',
            'user' => $user,
        ]);
    }

    public function mount() {
        $this->refreshTable();
    }

    public function openDeleteModal(User $user) {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => "Delete <span class='font-semibold'>$user->first_name $user->last_name</span> with id '$user->slug' the User?",
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, delete it',
                'method' => 'deleteUser',
                'params' => $user,
                'color' => 'negative',
            ],
            'reject' => [
                'label' => 'No, cancel',
            ],
        ]);
    }

    public function openRestoreModal($first_name, $last_name, $slug) {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => "Restore <span class='font-semibold'>$first_name $last_name</span> with id '$slug' the User?",
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, restore it',
                'method' => 'restoreUser',
                'params' => $slug,
                'color' => 'positive',
            ],
            'reject' => [
                'label' => 'No, cancel',
            ],
        ]);
    }

    public function deleteUser($user) {
        $user = User::whereSlug($user['slug'])->firstOrFail();
        $user->update([
            'status' => 'archived',
        ]);

        $user->delete();

        $this->emit('userDeleted', $user);
        $this->emit('refreshUserTable');

        $this->notification()->success(
            $title = "User <span class='font-semibold'>$user->first_name $user->last_name</span> deleted",
            $description = "User <span class='font-semibold'>$user->first_name $user->last_name</span> with id '$user->slug' deleted successfully",
        );
    }

    public function restoreUser($userSlug) {
        $user = User::onlyTrashed()->whereSlug($userSlug)->firstOrFail();
        $user->update([
            'status' => 'active',
        ]);

        $user->restore();

        $this->emit('userRestored', $user);
        $this->emit('refreshUserTable');

        $this->notification()->success(
            $title = "User <span class='font-semibold'>$user->first_name $user->last_name</span> restored",
            $description = "User <span class='font-semibold'>$user->first_name $user->last_name</span> with id '$user->slug' restored successfully",
        );
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.tables.user.user-setting-table');
    }
}
