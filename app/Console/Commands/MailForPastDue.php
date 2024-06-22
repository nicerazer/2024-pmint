<?php

namespace App\Console\Commands;

use App\Models\WorkLog;
use App\Notifications\WorkLogPastDue;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MailForPastDue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:mail-for-pastdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mail to users that has their worklog past due';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $worklogs_past_due = WorkLog::query()
            ->whereRaw('YEAR(work_logs.expected_at) > ' . now()->format('Y'))
            ->whereRaw('MONTH(work_logs.expected_at) > ' . now()->format('m'))
            ->whereRaw('DAY(work_logs.expected_at) > ' . now()->format('d'))
            ->select("author_id", DB::raw("id AS worklog_id"))
            // ->select("author_id")->groupBy("author_id")
            ->get();

        foreach($worklogs_past_due as $wl) {
            \App\Models\User::find($wl->author_id)->notify(new WorkLogPastDue($wl));
            // Mail::to($request->user())->send(new OrderShipped($order));
        }
    }
}
