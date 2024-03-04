<?php

namespace App\Livewire\WorkLogs;

use App\Helpers\UserRoleCodes;
use App\Helpers\WorkLogCodes;
use App\Helpers\WorkLogCountForAYear;
use App\Models\StaffSection;
use App\Models\Submission;
use App\Models\WorkLog;
use App\Models\WorkScope;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Renderless;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\LivewireComponentFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectDropdownFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RappasoftTable extends DataTableComponent
{
    #[Reactive]
    public Carbon $selected_month;
    // public $worklog_count_by_month;

    #[Renderless]
    #[On('update_month')]
    public function updateMonth($month) {
        // Log::debug('Rappasoft : '. $month);

        // Log::debug('Intercepted from parent');
        // Log::debug($month);
        // $this->selected_month = new Carbon($month);
        $this->dispatch('refreshDatatable');
        // Log::debug($this->selected_month);
    }

    // function __construct()
    // {
    //     $this->selected_month = now();
    // }

    #[On('evaluator2Evaluate')]
    public function evaluator2Evaluate(): bool {
        Log::debug('clicked');
        $affectedRows = $this->builder->update(['status' => WorkLogCodes::REVIEWED]);
        Log::debug('Updated count: '.$affectedRows);
        return false;
    }

    public function configure(): void
    {
        // $this->setDebugEnabled();
        $this->setSearchFieldAttributes([
            'default' => false,
            'class' => 'inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600',
        ]);
        $this->setConfigurableAreas([
            'before-toolbar' => [
                'components.work-logs.toolbar-right-start', [
                    'selected_month' => $this->selected_month,
                    // 'worklog_count_by_month' => $this->worklog_count_by_month,
                ]
            ],
        ]);
        $this->setPrimaryKey('id')
            ->setTableRowUrl(function($row) {
                return route('worklogs.show', $row);
            })
            ->setTableRowUrlTarget(function($row) {
                return 'navigate';
            });
        $this->setBulkActions([
            'doingSomething' => 'Sahkan Semua',
        ]);
            // ->setComponentWrapperAttributes([
            //     'id' => 'rappasofttable-id',
            //     'class' => 'w-full',
            // ]);
    }

    // protected $model = WorkLog::class;
    public function builder(): Builder
    {
        // $this->selected_month = new Carbon('2024-03-18');

        // $latestSubmissions = Submission::select(
        //     DB::raw('submissions.work_log_id AS wl_id_fk'),
        //     DB::raw('submissions.is_accept AS submissions_is_accept'),
        //     DB::raw('submissions.evaluated_at AS submissions_evaluated_at'),
        //     DB::raw('submissions.submitted_at AS submissions_submitted_at'))
        //     ->orderBy('number', 'desc')
        //     ->limit(1);
        // AUTHOR
        return WorkLog::indexQuery($this->selected_month);
        // return WorkLog::query()
        //     ->leftJoin('work_scopes','work_logs.work_scope_id', '=', 'work_scopes.id')
        //     // ->leftJoin('submissions','work_logs.id', '=', 'submissions.wor_log_id')
        //     ->join('users','users.id', '=', 'work_logs.author_id')
        //     ->where('work_logs.author_id', [
        //             UserRoleCodes::EVALUATOR_1 => '!=',
        //             UserRoleCodes::EVALUATOR_2 => '!=',
        //             UserRoleCodes::STAFF => '=',
        //         ][session('selected_role_id')],
        //         auth()->user()->id)
        //     ->where(function (Builder $q) {
        //         $q->whereNotNull('work_logs.started_at')
        //         ->whereRaw('YEAR(work_logs.started_at) <= ' . $this->selected_month->format('Y'))
        //         ->whereRaw('MONTH(work_logs.started_at) <= ' . $this->selected_month->format('m'));
        //     })
        //     ->where(function (Builder $q) {
        //         $q->where(function (Builder $q) {
        //             $q->whereNotNull('work_logs.expected_at')
        //             ->whereRaw('YEAR(work_logs.expected_at) >= ' . $this->selected_month->format('Y'))
        //             ->whereRaw('MONTH(work_logs.expected_at) >= ' . $this->selected_month->format('m'));
        //         })
        //         ->orWhere(function (Builder $q) {
        //             $q->whereNotNull('submissions_submitted_at')
        //             ->whereRaw('YEAR(submissions_submitted_at) >= ' . $this->selected_month->format('Y'))
        //             ->whereRaw('MONTH(submissions_submitted_at) >= ' . $this->selected_month->format('m'));
        //         })
        //         ;
        //     })
        //     ->when()
        //     // Only show submitted submissions
        //     ->when(session('selected_role_id') == UserRoleCodes::EVALUATOR_2, function (Builder $query) {
        //             $query->whereNotNull('wl_id_fk')
        //             ->where('submissions_is_accept', TRUE);
        //     })
        //     ->select('work_logs.id', 'users.name', 'work_scopes.title')
        //     ->leftJoinSub($latestSubmissions, 'latest_submission_id', function (JoinClause $join) {
        //         $join->on('work_logs.id', '=', 'wl_id_fk');
        //     })
        //     ->select('work_logs.*', 'users.name', 'work_scopes.title')
        //     ;
    }

    // public function mount(WorkLog $model, Carbon $selected_month)
    // {
    //     $this->selected_month = $selected_month;
    //     $this->model = $model;
    // }

    public function doingSomething() {
        Log::info('Doing something...');
        foreach($this->getSelected() as $item) {
        }
        $this->clearSelected();
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id'),
            Column::make('Aktiviti')
                ->label(
                    fn($row, Column $column) => $row->workScopeTitle()
                )
                ->searchable(
                    fn(Builder $query, $searchTerm) => $query
                        ->orWhere('work_scopes.title', 'like', "%$searchTerm%")
                        ->orWhere('work_logs.custom_workscope_title', 'like', "%$searchTerm%")
                )
                ->sortable(),
            session('selected_role_id') == UserRoleCodes::EVALUATOR_1 ?
                Column::make('Staff', 'author_id')->label(
                    fn($row, Column $column) => $row->authorName()
                )->sortable()
                : NULL,
            Column::make('Status', 'status')->view('components.work-logs.status-badge'),
            Column::make('Nota', 'description')
                ->searchable()
                ->sortable(),
            // Column::make('Penghantaran Terkini')
            //     ->label(
            //         fn($row, Column $column) => $row->latestSubmissionBody()
            //     )
            //     ->searchable()
            //     ->sortable(),
            Column::make('Bahagian', 'section.name'),
            Column::make('Unit', 'workscope.staffUnit.name'),
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
        return array_values(array_filter([
            SelectFilter::make('Status')
                ->options(WorkLogCodes::GETOPTIONS())
                ->filter(function(Builder $query, string $value) {
                    if ($value >= 0)
                        $query->where('work_logs.status', $value);
                }),

            session('selected_role_id') == UserRoleCodes::EVALUATOR_1 || session('selected_role_id') == UserRoleCodes::EVALUATOR_2 ?
                SelectFilter::make('Bahagian')
                    ->options(
                        ['' => 'Semua Bahagian'] +
                        Auth::user()
                            ->sectionsByRole()
                            ->orderBy('name')
                            ->get()
                            ->keyBy('id')
                            ->map(fn($section) => "📝 $section->name")
                            ->toArray()
                    )
                    ->filter(function(Builder $query, string $value) {
                        $query->where('work_logs.staff_section_id', $value);
                    }):NULL,
            // LivewireComponentFilter::make('My External Filter')
            //     ->setLivewireComponent('work-logs.filters.month')
            //     ->filter(function (Builder $builder, string $value) {
            //         $date = new Carbon($value);
            //         $builder->where(function (Builder $q) use ($date) {
            //             $q->whereNotNull('work_logs.created_at')
            //             ->whereRaw('YEAR(work_logs.created_at) <= ' . $date->format('Y'))
            //             ->whereRaw('MONTH(work_logs.created_at) <= ' . $date->format('m'));
            //         })->where(function (Builder $q) use ($date) {
            //             $q->where(function (Builder $q) use ($date) {
            //                 $q->whereNotNull('work_logs.expected_at')
            //                 ->whereRaw('YEAR(work_logs.expected_at) >= ' . $date->format('Y'))
            //                 ->whereRaw('MONTH(work_logs.expected_at) >= ' . $date->format('m'));
            //             })
            //             ->orWhere(function (Builder $q) use ($date) {
            //                 $q->whereNotNull('submissions.submitted_at')
            //                 ->whereRaw('YEAR(submissions.submitted_at) >= ' . $date->format('Y'))
            //                 ->whereRaw('MONTH(submissions.submitted_at) >= ' . $date->format('m'));
            //             });
            //         });
            //     }),
            // DateFilter::make('Created At')
            //     ->config([
            //         'min' => '2020-01-01',
            //         'max' => '2023-12-31',
            //         'pillFormat' => 'd M Y',
            //     ])->setFilterDefaultValue('2023-08-01'),
            SelectFilter::make('Skop Kerja', 'workScopeTitle')
                ->options(
                    ['-1' => '💼 Aktiviti Sampingan'] +
                    WorkScope::query()
                        ->orderBy('title')
                        ->get()
                        ->keyBy('id')
                        ->map(fn($workscope) => "📝 $workscope->title")
                        ->toArray()
                )
                ->filter(function (Builder $query, string $search) {
                    if ($search == -1) {
                        $query->where('custom_workscope_title', '!=', "''");
                    } else {
                        $query->where('work_scope_id', $search);
                    }
                })
                // ->hiddenFromAll()
                // ->filter(function(Builder $query, string $value) {
                //     $query->when(($value), fn($q, $v) => $q->where('work_logs.work_scope_id', $v));
                // })
                // ->setFirstOption('Semua Aktiviti'),
        ]));
    }
}
        // Log::info ($this->getAppliedFilters());
