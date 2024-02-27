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

    public function addYear() {
        $this->selected_date->addYear()->setMonth(1);
        $this->dispatch('update_month', $this->selected_date->toDateString());
    }

    public function subYear() {
        $this->selected_date->subYear()->setMonth(1);
        $this->dispatch('update_month', $this->selected_date->toDateString());
        // $this->dispatch('update_month', $this->selected_date->subYear()->setMonth(1));
    }

    public function setMonth(string $month_name): void {
        $date = new Carbon($month_name);
        $this->selected_date->setMonth($date->month);
        $this->dispatch('update_month', $this->selected_date->toDateString());
    }

    public function mount()
    {
        $this->selected_date = now();
    }

    public function render()
    {
        Log::debug('Source : '. $this->selected_date);
        $this->worklog_count_by_month = WorkLogCountForAYear::make($this->selected_date);
        return view('livewire.work-logs.filters.month');
    }
}
