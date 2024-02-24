<?php

namespace App\Livewire\WorkLogs\Filters;

use App\Helpers\WorkLogCountForAYear;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Url;
use Livewire\Component;
use Rappasoft\LaravelLivewireTables\Views\Traits\IsExternalFilter;

class Month extends Component
{
    public Carbon $selected_date;

    #[Url(as: 'bulan')]
    public string $month_translated;
    private Collection $worklog_count_by_month;

    public function addYear() {
        $this->dispatch('update_month', $this->selected_date->addYear()->setMonth(1));
        Log::debug('IM ALIVEEEEEE');
    }

    public function subYear() {
        $this->dispatch('update_month', $this->selected_date->subYear()->setMonth(1));
    }

    public function setMonth(string $month_name): void {
        $date = new Carbon($month_name);
        $this->selected_date->setMonth($date->month);
        $this->dispatch('update_month', $this->selected_date);

        // Log::debug('Setting Month : '. $this->selected_date);

        // $this->month_translated = $this->selected_date->monthName;
        // $this->dispatch('update_month', month: $month_name);
        // Log::debug('YOYOYOYOY');

        // $this->initCounts();
        // $this->worklogs_in_a_month = WorkLogCountForAYear::make($this->selected_date);
        // $this->resetPage();
    }

    public function mount()
    {
        // Log::debug('IM ALIVEEEEEE');
        // Log::debug($this->selected_date);
        $this->selected_date = now();
        // Log::debug($this->selected_date);
        // $this->value = $this->selected_date->format('F Y');
    }

    public function render()
    {
        $this->worklog_count_by_month = WorkLogCountForAYear::make($this->selected_date);
        return view('livewire.work-logs.filters.month');
    }
}
