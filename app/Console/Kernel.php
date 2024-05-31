<?php

namespace App\Console;

use App\Console\Commands\DeleteTempUploadedFiles;
use App\Models\WorkLog;
use App\Notifications\WorkLogPastDue;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(DeleteTempUploadedFiles::class)->hourly();
        $schedule->call(function () {
            $worklogs_past_due = WorkLog::query()
                ->whereRaw('YEAR(work_logs.expected_at) > ' . now()->format('Y'))
                ->whereRaw('MONTH(work_logs.expected_at) > ' . now()->format('m'))
                ->whereRaw('DAY(work_logs.expected_at) > ' . now()->format('d'))
                ->select("author_id", DB::raw("id AS worklog_id"))
                // ->select("author_id")->groupBy("author_id")
                ->get();

            foreach($worklogs_past_due as $wl) {
                \App\Models\User::find($wl->author_id)->notify(new WorkLogPastDue($wl->worklog_id));
                // Mail::to($request->user())->send(new OrderShipped($order));
            }
        })->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
