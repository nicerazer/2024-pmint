<?php

namespace App\View\Components\WorkLogs;

use App\Models\WorkLog;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StatusBadge extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public WorkLog $worklog,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.work-logs.status-badge');
    }
}
