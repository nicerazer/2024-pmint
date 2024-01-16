<?php

namespace App\Livewire\WorkLogs;

use App\Helpers\WorkLogCodes;
use App\Models\WorkLog;
use App\Models\WorkScope;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectDropdownFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class RappasoftTable extends DataTableComponent
{
    // protected $model = WorkLog::class;
    public function builder(): Builder
    {


        return WorkLog::query()
            ->leftJoin('work_scopes','work_logs.work_scope_id', '=', 'work_scopes.id')
            ->join('users','users.id', '=', 'work_logs.author_id')
            ->where('work_logs.author_id', auth()->user()->id)
            ->whereYear('work_logs.created_at', '2024')
            ->whereMonth('work_logs.created_at', '1')
            ->select('work_logs.*', 'users.name', 'work_scopes.title');
            // ->with() // Eager load anything
            // ->join() // Join some tables
            // ->select(); // Select some things
    }

    // public function getSomeOtherValue($row, $column) {
    //     dd();
    // }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableRowUrl(function($row) {
                return route('worklogs.show', $row);
            })
            ->setTableRowUrlTarget(function($row) {
                // if ($row->isExternal()) {
                //     return '_blank';
                // }

                return 'navigate';
            });
            // ->setComponentWrapperAttributes([
            //     'id' => 'rappasofttable-id',
            //     'class' => 'w-full',
            // ]);
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id'),
            Column::make('Aktiviti')
                ->label(
                    fn($row, Column $column) => $row->workScopeTitle()
                )
                // ->secondaryHeader($this->getFilterByKey('work_scope_id'))
                ->searchable(
                    fn(Builder $query, $searchTerm) => $query
                        ->orWhere('work_scopes.title', 'like', "%$searchTerm%")
                        ->orWhere('work_logs.custom_workscope_title', 'like', "%$searchTerm%")
                )
                ->sortable(),
            Column::make('description')
                ->searchable()
                ->sortable(),
            DateColumn::make('Tarikh Mula', 'started_at')
                ->searchable()
                ->sortable(),
            DateColumn::make('Jangka Siap', 'expected_at')
                ->searchable()
                ->sortable(),
        ];
    }


    public function filters(): array
    {
        return [
            SelectFilter::make('Status')
                ->options(WorkLogCodes::GETOPTIONS())
                ->filter(function(Builder $query, string $value) {
                    $query->when(($value > 0), fn($q, $v) => $q->where('work_logs.status', $v));
                }),
                // ->setFirstOption(0),

            // MultiSelectFilter::make('Workscopes')
            //     ->options(
            //         WorkScope::query()
            //             ->orderBy('title')
            //             ->get()
            //             ->keyBy('id')
            //             ->map(fn($workscope) => $workscope->title)
            //             ->toArray()
            //     )
                // ->filter(function (Builder $query, string $search) {
                //     $query->where('work_scope_id', $search);
                // })
                // ->hiddenFromAll()
                // ->filter(function(Builder $query, string $value) {
                //     $query->when(($value), fn($q, $v) => $q->where('work_logs.work_scope_id', $v));
                // })
                // ->setFirstOption('Semua Aktiviti'),
        ];
    }
}
