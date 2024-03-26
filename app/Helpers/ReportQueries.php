<?php

namespace App\Helpers;

use App\Models\WorkLog;
use Illuminate\Support\Facades\DB;

class ReportQueries {
    static public function monthly($date) {
    }
    static public function annual($date) {
        $year = 2024;
        $wl_count_infos = WorkLog::query()
            ->where("status", WorkLogCodes::REVIEWED)
            ->join("users", "users.id", "=", "work_logs.author_id")
            ->select(
            DB::raw("MONTH(started_at) AS month_started_at"),
            "users.name",
            "author_id",
            DB::raw("COUNT(author_id) AS count")
            )
            ->whereRaw("YEAR(started_at) >= " . $year)
            ->whereRaw("YEAR(started_at) < " . $year + 1)
            ->groupBy("author_id", "month_started_at")
            ->orderBy("month_started_at")
            ->orderBy("author_id")
            ->get();

        $month_abbs = ['Jan','Feb','Mac','Apr','Mei','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

        $data = collect();
        for ($i = 0; $i < 12; ++$i) {
            $temp_builder = collect([
            "x" => $month_abbs[$i]
            ]);
            $temp_wl_infos = $wl_count_infos->where("month_started_at", $i + 1);
            $temp_wl_infos->each(function ($wl_info) use ($temp_builder) {
            $temp_builder[$wl_info->name . " #" . $wl_info->author_id] = $wl_info->count;
            });
            $data->push($temp_builder->all());
        }

        $staffs = $wl_count_infos
            ->map(fn($i) => $i->name . " #" . $i->author_id)
            ->unique()
            ->values()
            ->all();

        return ['data' => $data, 'staffs' => $staffs];
    }

}
