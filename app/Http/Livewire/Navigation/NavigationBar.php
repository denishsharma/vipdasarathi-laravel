<?php

namespace App\Http\Livewire\Navigation;

use Livewire\Component;

class NavigationBar extends Component {
    public $active = 'home';

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('livewire.navigation.navigation-bar');
    }
}
