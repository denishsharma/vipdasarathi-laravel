<?php

namespace App\Http\Livewire\Modals;

use App\Models\User;
use App\Models\Organization;
use LivewireUI\Modal\ModalComponent;

class EditUserDetails extends ModalComponent {
    public string $actionType;

    public $firstName;
    public $lastName;
    public $mobile;
    public $email;
    public $password;
    public $organization;

    public User $user;

    protected $rules = [
        'firstName' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8',
        'organization' => 'required',
    ];

    public function updateUser() {
        $this->closeModal();
    }

    public function addUser() {
        $this->validate();

        $organization = Organization::whereSlug($this->organization)->firstOrFail();

        $user = $organization->users()->create([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'password' => \Hash::make($this->password),
            'organization_id' => $this->organization,
        ]);

        $user->user_profile()->create([
            'mobile' => $this->mobile,
        ]);

        $this->emit('userAdded', $user);
        $this->closeModal();
    }

    public function mount(string $actionType, User $user = null) {
        if ($actionType === 'edit') {
            $this->actionType = 'edit';
            $this->user = $user;

        } else if ($actionType === 'add') {
            $this->actionType = 'add';
            $faker = \Faker\Factory::create('en_IN');

            $this->firstName = $faker->firstName;
            $this->lastName = $faker->lastName;
            $this->mobile = $faker->numerify('98########');
            $this->email = strtolower($this->firstName . $this->lastName . '@gmail.com');
            $this->password = '12345678';
            $this->organization = 'ndrf-national';
        }
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.modals.edit-user-details');
    }
}
