<?php

namespace App\Http\Controllers;

use App\Helpers\ReportQueries;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DataReportController extends Controller
{
    // ADMIN AREA
    public $model_context = 'staff_section';
    public $model_id = -1;
    public $model_is_creating = false;
    public $staff_sections;
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $month = 3;
        $year = 2024;
        $date_cursor = new Carbon("$year-$month-01");

        $monthlyStaff = ReportQueries::monthlyStaff($date_cursor);
        $monthlyUnit = ReportQueries::monthlyUnit($date_cursor);
        $monthlySection = ReportQueries::monthlySection($date_cursor);
        $monthlyOverall = ReportQueries::monthlyOverall($date_cursor);
        $annualSection = ReportQueries::annualSection($date_cursor);

        return view('pages.reports.index', [
            'monthly_staff' => [
                'data' => $monthlyStaff,
            ],
            'monthly_unit' => [
                'data' => $monthlyUnit['data']->all(),
                'labels' => $monthlyUnit['staffs'],
            ],
            'monthly_section' => [
                'data' => $monthlySection['data']->all(),
                'labels' => $monthlySection['labels'],
            ],
            'monthly_overall' => $monthlyOverall,
            'annual_section' => [
                'data' => $annualSection,
            ],
        ]);

        return view('pages.reports.index');
    }
}
