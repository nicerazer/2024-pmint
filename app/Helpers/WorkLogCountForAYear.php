<?php

namespace App\Helpers;

use App\Models\WorkLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * === Used in ===
 * resources\views\livewire\work-logs\index-table.blade.php
 * app\Livewire\WorkLogs\IndexTable.php
 */
class WorkLogCountForAYear {
    static public function make(Carbon $year) {
        // TODO: Limit search to only selected year. Currently this queries lifetime result
        // TODO: Auto select year to current if year searched for is beyond (future)
        $months_and_total_worklogs = WorkLog::join('users', 'work_logs.author_id', '=', 'users.id')
        ->join('staff_units', 'users.staff_unit_id', '=', 'staff_units.id')
        ->select(
            DB::raw("DATE_FORMAT(work_logs.started_at, '%M %Y') AS month"),
            DB::raw("COUNT(work_logs.id) as total")
        )
        ->groupBy('month')
        ->where('staff_units.id', 1)->distinct()->get()->toArray();
        // Transform into collection and make it into associative array; ['MONTH' => 'TOTAL']
        // Example: ['September 2023' => 5]
        $months_and_total_worklogs = collect($months_and_total_worklogs);
        $months_and_total_worklogs = $months_and_total_worklogs->mapWithKeys(function (array $item, int $key) {
            return [$item['month'] => $item['total']];
        });

        // $months_and_total_worklogs = ;

        Log::info($months_and_total_worklogs);

        // Year to be prepared to generate months
        $searchYear = $year->copy()->format('Y');
        Log::info('==== GENERATE INFO ==== ');
        Log::info('Search year: '. $searchYear);
        // $searchYear = $year->format('Y');
        // Check if search year same as the current year
        $now = now();

        $isCurrentYear = $now->format('Y') == $searchYear;
        Log::info('Is current year?: '. $isCurrentYear);

        // Track month to be iterated to prepare for the generated month
        $trackMonth = $year->copy()->setTime(0,0,0,0)->setDay(1)->setMonth(now()->month);
        Log::info('Track month: '. $trackMonth);

        // If the current year is NOT the same as the search year (past years), generate for the whole year
        // If it's the same year, generate only up until current month (if right now is april, generate the list until april)
        if (! $isCurrentYear) $trackMonth->setMonth(12);

        $infiniteMonths = collect();
        Log::info('Generating: Starting date - '.$trackMonth);

        while ($trackMonth->year == $searchYear) {
            $_trackMonth = $trackMonth->format('F Y');
            // Get total worklog from database for the created array
            $total_worklog_cursor =
                isset($months_and_total_worklogs[$_trackMonth])
                    ? $months_and_total_worklogs[$_trackMonth] : 0;

            $infiniteMonths->push([
                'month' => $_trackMonth,
                'total' => $total_worklog_cursor,
            ]);

            Log::info('======== Iterating month: '.$trackMonth);
            $trackMonth->subMonth();
            // Log::info('After sub: '.$trackMonth);
        }

        return $infiniteMonths;
    }
}
