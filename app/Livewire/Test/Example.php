<?php

namespace App\Livewire\Test;

use App\Helpers\UserRoleCodes;
use App\Helpers\WorkLogCodes;
use App\Models\StaffSection;
use App\Models\Submission;
use App\Models\WorkLog;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class Example extends Component
{
    public array $labels = [
        2010,
        2011,
        2012,
        2013,
        2014,
        2015,
        2016,
    ];

    public array $datasets = [
        'label' => 'Acquisitions by year',
        'data' => [
            10,
            20,
            15,
            25,
            22,
            30,
            28,
        ]
    ];

    public $report_monthly_staff = [
        [ 'month' => 'Jan', 'count' => 10 ],
        [ 'month' => 'Feb', 'count' => 20 ],
        [ 'month' => 'Mac', 'count' => 15 ],
        [ 'month' => 'Apr', 'count' => 25 ],
        [ 'month' => 'Jun', 'count' => 22 ],
        [ 'month' => 'Jul', 'count' => 30 ],
        [ 'month' => 'Aug', 'count' => 28 ],
    ];


    public function changesomething() {
        $this->report_monthly_staff[0]['count'] = 100;
        $this->dispatch('change-something');
    }

    public function render() {
        return view('livewire.test.example');
    }
}
