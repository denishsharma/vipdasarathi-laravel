<?php

namespace App\Http\Livewire\Modals;

use App\Models\User;
use WireUi\Traits\Actions;
use App\Models\Organization;
use LivewireUI\Modal\ModalComponent;

class EditUserDetails extends ModalComponent {
    use Actions;

    public string $actionType;

    public $firstName;
    public $lastName;
    public $mobile;
    public $email;
    public $password;
    public $organization;
    public $slug;

    public $user;

    protected $rules = [
        'firstName' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8',
        'organization' => 'required',
        'slug' => 'required|unique:users',
    ];

    public function updateUser() {
        $this->validate([
            'firstName' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'password' => 'required|min:8',
            'organization' => 'required',
        ]);

        $user = User::whereSlug($this->user->slug)->firstOrFail();

        $userAttributes = [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'organization_id' => Organization::whereSlug($this->organization)->firstOrFail()->id,
        ];

        if ($this->password) {
            $userAttributes['password'] = \Hash::make($this->password);
        }

        $user->update($userAttributes);
        $user->user_profile->update([
            'mobile' => $this->mobile,
        ]);

        $this->emit('userUpdated', $user);
        $this->emit('refreshUserTable');

        $this->notification()->success(
            $title = "User $this->firstName $this->lastName updated",
            $description = "User with id $user->slug has been updated successfully.",
        );

        $this->closeModal();
    }

    public function addUser() {
        $this->slug = \Str::slug($this->firstName . ' ' . \Str::substr($this->lastName, 0, 1) . ' ' . \Str::random(6));
        $this->validate();

        $organization = Organization::whereSlug($this->organization)->firstOrFail();

        $user = $organization->users()->create([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'password' => \Hash::make($this->password),
            'organization_id' => $this->organization,
            'slug' => $this->slug,
        ]);

        $user->user_profile()->create([
            'mobile' => $this->mobile,
        ]);

        $this->emit('userAdded', $user);
        $this->emit('refreshUserTable');

        $this->notification()->success(
            $title = "User $this->firstName $this->lastName added",
            $description = "User has been registered successfully and added in the $organization->name organization",
        );

        $this->closeModal();
    }

    public function mount(string $actionType, User $user) {
        if ($actionType === 'edit') {
            $this->actionType = 'edit';
            $this->user = $user;

            $this->fill([
                'firstName' => $user->first_name,
                'lastName' => $user->last_name,
                'mobile' => $user->user_profile->mobile,
                'email' => $user->email,
                'organization' => $user->organization->slug,
                'password' => $user->password,
            ]);

        } else if ($actionType === 'add') {
            $this->actionType = 'add';
            $faker = \Faker\Factory::create('en_IN');

            $this->firstName = $faker->firstName;
            $this->lastName = $faker->lastName;
            $this->mobile = $faker->numerify('98########');
            $this->email = strtolower($this->firstName . $this->lastName . '@gmail.com');
            $this->password = '12345678';
            $this->organization = Organization::all()->random()->slug;
        }
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.modals.edit-user-details');
    }
}
