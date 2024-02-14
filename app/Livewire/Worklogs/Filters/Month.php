<?php

namespace App\Livewire\WorkLogs\Filters;

use App\Helpers\WorkLogCountForAYear;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Url;
use Livewire\Component;

class Month extends Component
{
    public Carbon $selected_month;
    #[Url(as: 'bulan')]
    public string $month_translated;
    public $worklog_count_by_month;

    public function addYear() {
        $this->selected_month->addYear();
        $this->month_translated = $this->selected_month->monthName;
        $this->dispatch('update_month', month: $this->selected_month);
        // $this->worklogs_in_a_month = WorkLogCountForAYear::make($this->selected_month);
        // $this->initCounts();
        // $this->resetPage();
    }

    public function subYear() {
        $this->selected_month->subYear();
        $this->month_translated = $this->selected_month->monthName;
        $this->dispatch('update_month', month: $this->selected_month);

        // $this->initCounts();
        // $this->worklogs_in_a_month = WorkLogCountForAYear::make($this->selected_month);
        // $this->resetPage();
    }

    public function setMonth(string $month_name): void {
        $this->selected_month = new Carbon($month_name);
        $this->month_translated = $this->selected_month->monthName;
        $this->dispatch('update_month', month: $this->selected_month);

        // $this->initCounts();
        // $this->worklogs_in_a_month = WorkLogCountForAYear::make($this->selected_month);
        // $this->resetPage();
    }

    public function mount()
    {
        $this->selected_month = now();
    }

    public function render()
    {
        $this->worklog_count_by_month = WorkLogCountForAYear::make($this->selected_month);
        return view('livewire.work-logs.filters.month');
    }
}
