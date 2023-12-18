<?php

namespace App\Livewire\Reports;

use App\Models\StaffUnit;
use App\Models\WorkLog;
use App\Models\WorkScope;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class InfiniteMonths extends Component
{
    // public $infiniteMonths = [];
    public $currentLoadAmount = 10;
    public $availableMonths;
    public int $monthCounts;
    // public $max = 10;
    public $staffUnit;

    public function mount(WorkLog $availableMonths)
    {
        $this->availableMonths = WorkLog::join('users', 'work_logs.author_id', '=', 'users.id')
        ->join('staff_units', 'users.staff_unit_id', '=', 'staff_units.id')
        ->select(
            DB::raw("DATE_FORMAT(work_logs.created_at, '%M %Y') AS month_title"),
            DB::raw("COUNT(work_logs.id) as total")
        )
        ->groupBy('month_title')
        ->where('staff_units.id', $this->staffUnit->id)->distinct()->get();

        $this->monthCounts = $this->availableMonths->count();
    }

    public function render()
    {
        return view('livewire.reports.infinite-months', ['infiniteMonths' => $this->generateMonths()]);
    }

    public function loadMoreMonths()
    {
        // if ($this->monthCounts > $this->currentLoadAmount) {
        //     if ($this->monthCounts - $this->currentLoadAmount > 10) {
        //         $this->currentLoadAmount += 10;
        //     } else {
        //         $this->currentLoadAmount += $this->monthCounts - $this->currentLoadAmount;
        //     }
        // }
    }

    private function generateMonths() {
        $infiniteMonths = [];
        $monthCursor = now();

        for($i = 0; $i < $this->currentLoadAmount; ++$i) {
            array_push($infiniteMonths, [
                'title' => $monthCursor->format('F Y'),
                'total' => ($this->availableMonths->pluck('month_title')[$monthCursor->format('F Y')] ?? 0),
            ]);
            $monthCursor->subMonth();
        }

        // staffunit ->  -> worklogs
        // OR
        // staffunit -> worklogs

        // Collect database months
        // Generate infinite months
        // Find last month
        // Limit infinite until there

        // Considerations!!!!
        // When theres scopes that doesnt exists

        return $infiniteMonths;
    }
}
