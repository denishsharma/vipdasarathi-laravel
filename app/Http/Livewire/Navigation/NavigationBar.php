<?php

namespace App\Http\Livewire\Navigation;

use Livewire\Component;

class NavigationBar extends Component {
    public $active = 'home';

    public function logoutUser() {
        auth()->logout();
        redirect()->route('auth.login');
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.navigation.navigation-bar');
    }
}
