<?php

namespace App\Livewire\Home;

use App\Helpers\WorkLogCodes;
use App\Models\WorkLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class StatsSummary extends Component
{
    public $selected_date;
    public $worklog_count_in_a_month_by_statuses;

    #[On('update_month')]
    public function ahhhh($date) {
        $this->selected_date = $date;
        Log::debug('AAAAAA');
    }

    public function render()
    {
        $res = WorkLog::query()
        ->select(DB::raw('COUNT(id) AS count'), 'status')
        ->groupBy('status')->pluck('count', 'status');
        $this->worklog_count_in_a_month_by_statuses = [
            // WorkLogCodes::ALL => $res[WorkLogCodes::ALL]->count ?: 0,
            WorkLogCodes::ONGOING => $res->get(WorkLogCodes::ONGOING) ?: 0,
            WorkLogCodes::SUBMITTED => $res->get(WorkLogCodes::SUBMITTED) ?: 0,
            WorkLogCodes::TOREVISE => $res->get(WorkLogCodes::TOREVISE) ?: 0,
            WorkLogCodes::COMPLETED => $res->get(WorkLogCodes::COMPLETED) ?: 0,
            WorkLogCodes::CLOSED => $res->get(WorkLogCodes::CLOSED) ?: 0,
            WorkLogCodes::REVIEWED => $res->get(WorkLogCodes::REVIEWED) ?: 0,
            WorkLogCodes::NOTYETEVALUATED => $res->get(WorkLogCodes::NOTYETEVALUATED) ?: 0,
        ];
        return view('livewire.home.stats-summary');
    }
}
