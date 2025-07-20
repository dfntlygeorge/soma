<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EditingNotice extends Component
{
    public bool $onboarded;

    public function __construct()
    {
        // Grab the flag once; passes cleanly to the view.
        $this->onboarded = optional(auth()->user())->onboarded ?? false;
    }

    public function render()
    {
        return view('components.editing-notice');
    }
}
