<?php

namespace App\Helpers;

use App\Models\Submission;
use App\Models\WorkLog;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * === Used in ===
 * resources\views\livewire\work-logs\index-table.blade.php
 * app\Livewire\WorkLogs\IndexTable.php
 */
class WorkLogCountForAYear {
    static public function make(Carbon $year) {
        $latestSubmissions = Submission::select(
            DB::raw('submissions.work_log_id AS wl_id_fk'),
            DB::raw('submissions.is_accept AS submissions_is_accept'),
            DB::raw('submissions.evaluated_at AS submissions_evaluated_at'),
            DB::raw('submissions.submitted_at AS submissions_submitted_at'))
            ->orderBy('number', 'desc')
            ->limit(1);

        // TODO: Limit search to only selected year. Currently this queries lifetime result
        // TODO: Auto select year to current if year searched for is beyond (future)
        $months_and_total_worklogs = WorkLog::join('users', 'work_logs.author_id', '=', 'users.id')
        ->join('staff_units', 'users.staff_unit_id', '=', 'staff_units.id')
        ->select(
            DB::raw("DATE_FORMAT(work_logs.started_at, '%M %Y') AS month"),
            DB::raw("COUNT(work_logs.id) as total")
        )
        ->where('staff_units.id', auth()->user()->staff_unit_id)
        ->when(auth()->user()->currentlyIs(UserRoleCodes::STAFF), function (Builder $q) {
            $q->where('work_logs.author_id', auth()->user()->id);
        })
        ->when(auth()->user()->currentlyIs(UserRoleCodes::EVALUATOR_2), function (Builder $q) use ($latestSubmissions) {
            $q->leftJoinSub($latestSubmissions, 'latest_submission_id', function (JoinClause $join) {
                $join->on('work_logs.id', '=', 'wl_id_fk');
            });
            // $q->join('submissions')
            // $q->addSelect([
            //     'latestSubmission_select' => Submission::query()
            //         ->orderByDesc('number')
            //         ->whereColumn('work_logs.id', 'work_log_id')
            //         ->take(1)
            // ])
            // ->whereNotNull('latestSubmission_select');
        })
        ->groupBy('month')
        ->distinct()->get()->toArray();
        // Transform into collection and make it into associative array; ['MONTH' => 'TOTAL']
        // Example: ['September 2023' => 5]
        $months_and_total_worklogs = collect($months_and_total_worklogs);
        $months_and_total_worklogs = $months_and_total_worklogs->mapWithKeys(function (array $item, int $key) {
            return [$item['month'] => $item['total']];
        });

        // $months_and_total_worklogs = ;

        Log::debug($months_and_total_worklogs);

        // Year to be prepared to generate months
        $searchYear = $year->copy()->format('Y');
        Log::debug('');
        Log::debug('==== WORKLOG COUNTS: GENERATING LINKS ==== ');
        Log::debug('Search year: '. $searchYear);
        // $searchYear = $year->format('Y');
        // Check if search year same as the current year
        $now = now();

        $isCurrentYear = $now->format('Y') == $searchYear;
        // Log::debug('Is current year?: '. $isCurrentYear);

        // Track month to be iterated to prepare for the generated month
        $trackMonth = $year->copy()->setTime(0,0,0,0)->setDay(1)->setMonth(now()->month);
        // Log::debug('Track month: '. $trackMonth);

        // If the current year is NOT the same as the search year (past years), generate for the whole year
        // If it's the same year, generate only up until current month (if right now is april, generate the list until april)
        if (! $isCurrentYear) $trackMonth->setMonth(12);

        $infiniteMonths = collect();
        // Log::debug('Generating: Starting date - '.$trackMonth);

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

            // Log::debug('======== Iterating month: '.$trackMonth);
            $trackMonth->subMonth();
            // Log::debug('After sub: '.$trackMonth);
        }

        return $infiniteMonths;
    }
}
