<?php

namespace App\View\Components\Navigation\Sidebar;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class SidebarGroup extends Component {
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $label = '',
    ) {}

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|string|Closure {
        return view('components.navigation.sidebar.sidebar-group');
    }
}
