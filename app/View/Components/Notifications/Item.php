<?php

namespace App\View\Components\Notifications;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Notifications\DatabaseNotification;

class Item extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public DatabaseNotification $notif
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.notifications.item');
    }
}
