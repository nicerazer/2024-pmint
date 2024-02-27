<?php

namespace App\Livewire\Home;

use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class StatsSummary extends Component
{
    #[Reactive]
    public $worklog_count_in_a_month_by_statuses;
}
