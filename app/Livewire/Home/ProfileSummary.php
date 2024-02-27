<?php

namespace App\Livewire\Home;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class ProfileSummary extends Component
{
    #[Reactive]
    public $worklog_count_in_a_month_by_statuses;
}
