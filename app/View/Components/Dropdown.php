<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Dropdown extends Component
{
    public function __construct(
        public string $align = 'right',
        public string $width = '48',
        public string $contentClasses = 'py-1 bg-white'
    ) {}

    public function render()
    {
        return view('components.dropdown');
    }
}