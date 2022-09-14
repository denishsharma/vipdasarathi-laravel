<?php

namespace App\View\Components\Navigation\Breadcrumb;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class BreadcrumbItem extends Component {
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $href = '#',
        public string $icon = 'home',
        public string $label = '',
        public bool   $active = false,
        public string $type = 'normal',
        public bool   $start = false,
    ) {}

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|string|Closure {
        return view('components.navigation.breadcrumb.breadcrumb-item');
    }
}
