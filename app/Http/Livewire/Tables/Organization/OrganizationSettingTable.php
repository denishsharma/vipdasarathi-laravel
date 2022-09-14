<?php

namespace App\Http\Livewire\Tables\Organization;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\Organization;

class OrganizationSettingTable extends Component {
    use Actions;

    public $description;
    public $currentTab = 'active';

    public $organizations = [];

    protected $listeners = [
        'refreshOrganizationTable' => 'refreshTable',
        'organizationChangeTab' => 'changeTab',
    ];

    public function refreshTable($archived = false) {
        if ($archived || $this->currentTab == 'archived') {
            $this->organizations = Organization::onlyTrashed()->whereStatus('archived')->orderByDesc('created_at')->get();
        } else {
            $this->organizations = Organization::orderByDesc('created_at')->get();
        }
    }

    public function changeTab($tab) {
        $this->currentTab = $tab;

        if ($tab == 'archived') {
            $this->description = 'Here you will find all the archived/deleted organization. You can restore the deleted organizations from here.';
            $this->refreshTable(true);
        } else {
            $this->refreshTable();
        }
    }

    public function openEditModal($organization) {
        $this->emit('openModal', 'modals.edit-organization-details', [
            'actionType' => 'edit',
            'organization' => $organization,
        ]);
    }

    public function mount() {
        $this->refreshTable();
    }

    public function openDeleteModal($organization) {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Delete the Organization?',
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, delete it',
                'method' => 'deleteOrganization',
                'params' => $organization,
                'color' => 'negative',
            ],
            'reject' => [
                'label' => 'No, cancel',
            ],
        ]);
    }

    public function openRestoreModal($organization) {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Restore the Organization?',
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, restore it',
                'method' => 'restoreOrganization',
                'params' => $organization,
                'color' => 'positive',
            ],
            'reject' => [
                'label' => 'No, cancel',
            ],
        ]);
    }

    public function deleteOrganization($organization) {
        $organization = Organization::whereSlug($organization['slug'])->withCount('users')->firstOrFail();

        if ($organization->users_count > 0) {
            $this->notification()->error(
                $title = 'Cannot delete organization',
                $description = "Organization <span class='font-semibold'>$organization->name</span> has users, cannot delete",
            );
        } else {
            $organization->update([
                'status' => 'archived',
            ]);

            $organization->delete();

            $this->emit('organizationDeleted', $organization);
            $this->emit('refreshOrganizationTable');

            $this->notification()->success(
                $title = 'Organization deleted',
                $description = "Organization <span class='font-semibold'>$organization->name</span> deleted successfully",
            );
        }
    }

    public function restoreOrganization($organization) {
        $organization = Organization::onlyTrashed()->whereSlug($organization['slug'])->whereStatus('archived')->firstOrFail();

        $organization->restore();
        $organization->update([
            'status' => 'active',
        ]);

        $this->emit('organizationRestored', $organization);
        $this->emit('refreshOrganizationTable');

        $this->notification()->success(
            $title = 'Organization restored',
            $description = "Organization <span class='font-semibold'>$organization->name</span> restored successfully",
        );
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.tables.organization.organization-setting-table');
    }
}
