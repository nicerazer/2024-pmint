<?php

namespace App\Livewire\WorkLogs\Filters;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class StatusesDropdown extends Component {
    #[Reactive]
    public $status_index;
    #[Reactive]
    public $workLog_counts_by_statuses;

    public function render()
    {
        info($this->workLog_counts_by_statuses);
        return view('livewire.work-logs.filters.statuses-dropdown');
    }
}
