<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\WorkLog;
use Illuminate\Support\Facades\DB;

class ReportQueries {
    private static $months_abbrs = ['Jan','Feb','Mac','Apr','Mei','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];


    static public function monthlyStaff($date) {
        $author_id = User::find(3)->id;

        $year = 2024;
        $wl_count_infos = WorkLog::query()
            ->where("status", WorkLogCodes::REVIEWED)
            ->where("author_id", $author_id)
            ->select(DB::raw("MONTH(started_at) AS month"), DB::raw("COUNT(id) AS count"))
            ->whereRaw("YEAR(started_at) >= " . $year)
            ->whereRaw("YEAR(started_at) < " . $year + 1)
            ->groupBy("month")
            ->orderBy("month")
            ->get();

        $data = collect();

        for ($i = 0; $i < 12; ++$i) {
            $temp_builder = collect([
              "month" => self::$months_abbrs[$i]
            ]);
            $temp_wl_info = $wl_count_infos->where("month", $i + 1)->first();
            $temp_builder["count"] = $temp_wl_info->count ?? 0;
            $data->push($temp_builder->all());
        }

        return $data->all();
    }

    static public function monthlyUnit($date) {
        $year = 2024;
        $wl_count_infos = WorkLog::query()
            ->where("status", WorkLogCodes::REVIEWED)
            ->join("users", "users.id", "=", "work_logs.author_id")
            ->join("staff_units", "staff_units.id", "=", "users.staff_unit_id")
            ->select(
            DB::raw("MONTH(started_at) AS month_started_at"),
            "users.name",
            "author_id",
            DB::raw("COUNT(author_id) AS count")
            )
            ->where("staff_unit_id", 1)
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

    static public function monthlySection($date) {
        $year = 2024;

        $wl_count_infos = WorkLog::query()
        ->where("status", WorkLogCodes::REVIEWED)
        ->join("users", "users.id", "=", "work_logs.author_id")
        ->join("work_scopes", "work_scopes.id", "=", "work_logs.wrkscp_main_id")
        ->join("staff_units", "staff_units.id", "=", "work_scopes.staff_unit_id")
        ->join(
            "staff_sections",
            "staff_sections.id",
            "=",
            "staff_units.staff_section_id"
        )
        ->select(
            DB::raw("MONTH(started_at) AS month"),
            "staff_units.id AS staff_unit_id",
            "staff_units.name",
            DB::raw("COUNT(author_id) AS count")
        )
        ->where("staff_sections.id", 1)
        ->whereRaw("YEAR(started_at) >= " . $year)
        ->whereRaw("YEAR(started_at) < " . $year + 1)
        ->groupBy("month", "staff_units.id")
        ->orderBy("month")
        ->orderBy("staff_units.id")
        ->get();

        $data = collect();
        for ($i = 0; $i < 12; ++$i) {
            $temp_builder = collect([
                "x" => self::$months_abbrs[$i]
            ]);
            $temp_wl_infos = $wl_count_infos->where("month", $i + 1);
            $temp_wl_infos->each(function ($wl_info) use ($temp_builder) {
                $temp_builder[$wl_info->name . " #" . $wl_info->staff_unit_id] =
                $wl_info->count;
            });

            $data->push($temp_builder->all());
        }

        $labels = $wl_count_infos
        ->map(fn($i) => $i->name . " #" . $i->staff_unit_id)
        ->unique()
        ->values()
        ->all();

        return ['data' => $data, 'labels' => $labels];
    }

    static public function monthlyOverall() {
        $year = 2024;
        $wl_count_infos = WorkLog::query()
          ->join("work_scopes", "work_scopes.id", "=", "work_logs.wrkscp_main_id")
          ->join("staff_units", "staff_units.id", "=", "work_scopes.staff_unit_id")
          ->join(
            "staff_sections",
            "staff_sections.id",
            "=",
            "staff_units.staff_section_id"
          )
          ->where("status", WorkLogCodes::REVIEWED)
          ->where("author_id", 3)
          ->select(
            DB::raw("CONCAT(staff_sections.name,' #',staff_section_id) AS section"),
            DB::raw("MONTH(started_at) AS month"),
            DB::raw("COUNT(work_logs.id) AS count")
          )
          ->whereRaw("YEAR(started_at) >= " . $year)
          ->whereRaw("YEAR(started_at) < " . $year + 1)
          ->groupBy("staff_section_id", "month")
          ->orderBy("month")
          ->get();

        $data = collect();
        for ($i = 0; $i < 12; ++$i) {
            $temp_builder = collect([
                "x" => self::$months_abbrs[$i]
            ]);
            $temp_wl_infos = $wl_count_infos->where("month", $i + 1);
            $temp_wl_infos->each(function ($wl_info) use ($temp_builder) {
                $temp_builder[$wl_info->section] = $wl_info->count;
            });
            $data->push($temp_builder->all());
        }

        return [
            'data' => $data,
            'labels' => $wl_count_infos->map(fn($i) => $i->section)->unique()->all()
        ];
    }

    static public function annualSection() {
        $year = 2024;
        $wl_count_infos = WorkLog::query()
            ->join("work_scopes", "work_scopes.id", "=", "work_logs.wrkscp_main_id")
            ->join("staff_units", "staff_units.id", "=", "work_scopes.staff_unit_id")
            ->join(
                "staff_sections",
                "staff_sections.id",
                "=",
                "staff_units.staff_section_id"
            )
            ->where("status", WorkLogCodes::REVIEWED)
            ->where("author_id", 3)
            ->select(
                DB::raw("CONCAT(staff_sections.name,' #',staff_section_id) AS section"),
                DB::raw("COUNT(work_logs.id) AS count")
            )
            ->whereRaw("YEAR(started_at) >= " . $year)
            ->whereRaw("YEAR(started_at) < " . $year + 1)
            ->groupBy("staff_section_id")
            ->orderBy("staff_section_id")
            ->get();

        return $wl_count_infos->map(
            fn($v) => ["section" => $v->section, "count" => $v->count]
        )->all();
    }
}
