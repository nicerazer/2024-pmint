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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectDropdownFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class RappasoftTable extends DataTableComponent
{
    public Carbon $selected_month;
    public $worklog_count_by_month;

    #[On('update_month')]
    public function updateMonth($month) {
        Log::info('Intercepted from parent');
        Log::info($month);
        $this->selected_month = new Carbon($month);
    }

    function __construct()
    {
        $this->selected_month = now();
        $_month = $this->selected_month->copy();
        // $this->worklog_count_by_month = WorkLogCountForAYear::make($_month);
    }

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
        $this->setConfigurableAreas([
            'before-toolbar' => [
                'components.work-logs.toolbar-right-start', [
                    'selected_month' => $this->selected_month,
                    'worklog_count_by_month' => $this->worklog_count_by_month,
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
            'doingSomething' => 'Export',
        ]);
            // ->setComponentWrapperAttributes([
            //     'id' => 'rappasofttable-id',
            //     'class' => 'w-full',
            // ]);
    }

    // protected $model = WorkLog::class;
    public function builder(): Builder
    {
        // AUTHOR
        return WorkLog::query()
            ->leftJoin('work_scopes','work_logs.work_scope_id', '=', 'work_scopes.id')
            ->join('users','users.id', '=', 'work_logs.author_id')
            // ->with(['latestSubmission'])
            // ->join('staff_sections', 'staff_sections.id', '=', 'work_logs.staff_section_id')
            ->where('work_logs.author_id',
            [
                UserRoleCodes::EVALUATOR_1 => '!=',
                UserRoleCodes::EVALUATOR_2 => '!=',
                UserRoleCodes::STAFF => '=',
            ][session('selected_role_id')],
             auth()->user()->id)
            // ->when(auth()->user()->isEvaluator2(), function(Builder $q) {
            //     // $q->where('')
            // })
            // ->where()
            //         return $this->hasOne(Submission::class)->orderBy('number', 'desc')->limit(1);
            // ->whereYear('work_logs.created_at', $this->selected_month->copy()->addMonth()->format('Y'))
            ->where(function (Builder $q) {
                $q->where(function (Builder $q) {
                    $q->whereNotNull('work_logs.created_at')
                    ->whereRaw('YEAR(work_logs.created_at) >= ' . $this->selected_month->format('Y'))
                    ->whereRaw('MONTH(work_logs.created_at) >= ' . $this->selected_month->format('m'));
                    // ->whereYear('expected_at', '2024');
                });
            })
            // ->whereMonth('work_logs.created_at', $this->selected_month->copy()->addMonth()->format('m'))
            ->addSelect([
                'latestSubmission_select' => Submission::query()
                    ->orderByDesc('number')
                    ->where('work_logs.id', 'work_log_id')
                    ->take(1)
            ])
            ->select('work_logs.*', 'users.name', 'work_scopes.title');
            // ->with() // Eager load anything
            // ->join() // Join some tables
            // ->select(); // Select some things
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
            Column::make('Penghantaran Terkini')
                ->label(
                    fn($row, Column $column) => $row->latestSubmissionBody()
                )
                ->searchable()
                ->sortable(),
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
