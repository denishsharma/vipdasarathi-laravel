<?php

namespace App\View\Components\Navigation\Sidebar;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class SidebarItem extends Component {
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $href = '#',
        public string $icon = 'cog',
        public string $label = '',
        public bool   $active = false,
    ) {}

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|string|Closure {
        return view('components.navigation.sidebar.sidebar-item');
    }
}
