<?php

namespace App\Livewire;

use App\Helpers\ReportQueries;
use App\Models\StaffSection;
use App\Models\StaffUnit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
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
    public $date_cursor;
    public $monthly_staff;
    public $monthly_unit;
    public $monthly_section;
    public $monthly_overall;
    public $annual_section;
    public ?User $selected_staff;
    public ?User $selected_unit;
    public ?User $selected_section;

    #[On('update_month')]
    public function updateTheMonth(string $date) {
        $this->selected_month = new Carbon($date);
    }

    public function updateChart() {
        $updateChartContextString = 'update-chart-'.$this->model_context;
        Log::debug('Update context:' . $updateChartContextString);
        Log::debug('Model id:' . $this->model_id);
        $this->dispatch($updateChartContextString,
            self::getChartUpdateData()
        );
    }

    public function getChartUpdateData() : array {
        if ($this->model_context == 'staff') {
            return collect(
                ReportQueries::monthlyStaff($this->date_cursor, User::find($this->model_id))
                )->pluck("count")->all();
        }
        else if ($this->model_context == 'staff_unit') {
            $monthly_unit_temp = ReportQueries::monthlyUnit($this->date_cursor, $this->model_id);
            Log::debug($monthly_unit_temp);

            // return [];
            // Data is correct
            // $this->monthly_unit = [
            //     'data' => $monthly_unit_temp['data']->all(),
            //     'labels' => $monthly_unit_temp['staffs'],
            // ];
            return [
                'data' => $monthly_unit_temp['data']->all(),
                'labels' => $monthly_unit_temp['staffs'],
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
        $month = 3;
        $year = 2024;
        $this->date_cursor = new Carbon("$year-$month-01");

        // Set staff
        $this->selected_staff = null;
        if ($this->model_context == 'staff')
            $this->selected_staff = User::find($this->model_id);
        // Log::debug($this->selected_staff);

        $monthlyStaff = ReportQueries::monthlyStaff($this->date_cursor, User::find($this->model_id));
        $monthlyUnit = ReportQueries::monthlyUnit($this->date_cursor, $this->model_id);
        $monthlySection = ReportQueries::monthlySection($this->date_cursor);
        $monthlyOverall = ReportQueries::monthlyOverall($this->date_cursor);
        // $annualSection = ReportQueries::annualSection($this->date_cursor);

        $this->monthly_staff = [
            'data' => $monthlyStaff,
        ];
        $this->monthly_unit = [
            'data' => $monthlyUnit['data']->all(),
            'labels' => $monthlyUnit['staffs'],
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
