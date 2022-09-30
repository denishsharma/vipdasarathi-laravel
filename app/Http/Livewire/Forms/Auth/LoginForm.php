<?php

namespace App\Http\Livewire\Forms\Auth;

use Livewire\Component;
use WireUi\Traits\Actions;

class LoginForm extends Component {
    use Actions;

    public $email = 'johndoe@gmail.com';
    public $password = '12345678';
    public $rememberMe;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function performLogin() {
        $this->validate();

        $authAttempt = \Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
        ], $this->rememberMe);

        if ($authAttempt) {
            $this->redirect(route('cases.index'));
        } else {
            $this->notification()->error('Login failed', 'Invalid credentials');
        }
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.forms.auth.login-form');
    }
}
