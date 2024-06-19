<?php

namespace App\Livewire;

use App\Helpers\ReportQueries;
use App\Models\StaffSection;
use App\Models\StaffUnit;
use App\Models\User;
use App\Services\SpreadsheetExport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.app')]
class DataReport extends Component
{
    public Carbon $selected_month;
    public $model_context = 'staff_section';
    public $model_id = -1;
    public $is_creating = false;
    public $staff_sections;
    public Carbon $date_cursor;
    public $monthly_staff;
    public $monthly_unit;
    public $monthly_section;
    public $monthly_overall;
    public $annual_section;
    public ?User $selected_staff;
    public ?StaffUnit $selected_unit;
    public ?StaffSection $selected_section;

    #[On('update_month')]
    public function updateTheMonth(string $date) {
        $this->selected_month = new Carbon($date);
    }

    public function download() : \Symfony\Component\HttpFoundation\StreamedResponse {
        $sheet_exporter = new SpreadsheetExport();

        if (in_array($this->model_context, ['staff', 'staff_unit', 'staff_section'])) {
            return $sheet_exporter->{
                ['staff' => 'annualStaff', 'staff_unit' => 'annualUnit', 'staff_section' => 'annualSection'][$this->model_context]
            }($this->selected_month, $this->model_id);
            // Log::debug('CHECKPOINT 1');
            // return Storage::download($download_info[0], $download_info[1]);
        }

        // Log::debug('CHECKPOINT 2');
        return $sheet_exporter->annualOverall($this->selected_month);

        // Log::debug('CHECKPOINT 3');
        // return Storage::download($download_info[0], $download_info[1]);

    }

    public function updateChart() {
        $updateChartContextString = 'update-chart-'.$this->model_context;
        Log::debug('Update context:' . $updateChartContextString);
        Log::debug('Model id:' . $this->model_id);
        $this->dispatch($updateChartContextString,
            self::getChartUpdateData()
        );
        // Log::debug('Date outside: ' . $this->date_cursor);
    }

    public function getChartUpdateData() : array {
        if ($this->model_context == 'staff') {
            return collect(
                ReportQueries::monthlyStaff($this->selected_month, User::find($this->model_id))
                )->pluck("count")->all();
        } else if ($this->model_context == 'staff_unit') {
            $monthly_unit_temp = ReportQueries::monthlyUnit($this->selected_month, $this->model_id);
            return [
                'data' => $monthly_unit_temp['data']->all(),
                'labels' => $monthly_unit_temp['labels'],
            ];
        } else if ($this->model_context == 'staff_section') {
            $monthly_section_temp = ReportQueries::monthlySection($this->selected_month, $this->model_id);
            return [
                'data' => $monthly_section_temp['data']->all(),
                'labels' => $monthly_section_temp['labels'],
            ];
        } else if ($this->model_context == 'monthly_overall') {
            // return ReportQueries::monthlyOverall($this->selected_month);
            $monthly_overall_temp = ReportQueries::monthlyOverall($this->selected_month);
            return [
                'data' => $monthly_overall_temp['data']->all(),
                'labels' => $monthly_overall_temp['labels'],
            ];
        }
    }

    public function mount() {
        $this->selected_month = now();
        $this->model_context = session('admin_model_context') ? session('admin_model_context') : 'staff';
        $this->model_id = session('admin_model_id') ? session('admin_model_id') : -1;
    }

    public function render()
    {
        $this->staff_sections = StaffSection::query()->select('id', 'name')->get();
        // $month = 3;
        // $year = 2024;
        // $this->date_cursor = new Carbon("$year-$month-01");

        // Set staff
        $this->selected_staff = null;
        if ($this->model_context == 'staff')
            $this->selected_staff = User::find($this->model_id);

        $this->selected_unit = null;
        if ($this->model_context == 'staff_unit')
            $this->selected_unit = StaffUnit::find($this->model_id);

        $this->selected_section = null;
        if ($this->model_context == 'staff_section')
            $this->selected_section = StaffSection::find($this->model_id);
        // Log::debug($this->selected_staff);

        $monthlyStaff = ReportQueries::monthlyStaff($this->selected_month, User::find($this->model_id));
        $monthlyUnit = ReportQueries::monthlyUnit($this->selected_month, $this->model_id);
        $monthlySection = ReportQueries::monthlySection($this->selected_month, $this->model_id);
        $monthlyOverall = ReportQueries::monthlyOverall($this->selected_month);
        // $annualSection = ReportQueries::annualSection($this->date_cursor);

        $this->monthly_staff = [
            'data' => $monthlyStaff,
        ];
        $this->monthly_unit = [
            'data' => $monthlyUnit['data']->all(),
            'labels' => $monthlyUnit['labels'],
        ];
        $this->monthly_section = [
            'data' => $monthlySection['data']->all(),
            'labels' => $monthlySection['labels'],
        ];
        $this->monthly_overall = $monthlyOverall;
        // $this->annual_section = [
        //     'data' => $annualSection,
        // ];

        return view('livewire.data-report.index');
    }

    // TODO:  Mount init with empty datasets
    // Update data trip, use listener
}
