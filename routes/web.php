<?php

use App\Helpers\UserRoleCodes;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffSectionController;
use App\Http\Controllers\SwitchRoleController;
use App\Http\Controllers\TemporaryUploadController;
use App\Http\Controllers\UserWithoutRoleController;
use App\Http\Controllers\WorkLogController;
use App\Http\Controllers\WorkLogDocumentController;
use App\Http\Controllers\WorkLogImageController;
use App\Http\Controllers\WorkScopeController;
use App\Http\Middleware\HRIsPermitted;
use App\Models\StaffSection;
use App\Models\Submission;
use App\Models\WorkLog;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Livewire\Home\Index as HomeIndex;

// auth()->logout();
// session()->clear = null;

// if (! auth()->check())
    // auth()->login(User::where('email', 'evaluator-2@mail.com')->first());

Route::get('/pictest', function () {
    // return fake()->imageUrl();
    // return "<img src='" . Submission::first()->getFirstMediaUrl('images') . "' />";
    // return "<img src='" . database_path('seeders/stubs/photo-1550258987-190a2d41a8ba.jpg') . "' />";
    // return '<img src="">';
});

Route::get('/report', function () {
    $month = 1;
    $year = 2024;
    $date_cursor = new Carbon("$year-$month-01");

    $selected_section = StaffSection::inRandomOrder()->first();
    $worklogs = WorkLog::where([
        ['started_at', '>=', $date_cursor->toDateString()],
        ['expected_at', '<=', $date_cursor->addMonth()->subDay()->toDateString()],
        ['staff_section_id', $selected_section->id]
    ])
    ->get();

    return view('pages.reports.index', compact('worklogs'));
});

Route::get('/organization-treeview', function () {
    if (auth()->user()->currentlyIs(UserRoleCodes::EVALUATOR_1))
        return view('pages.organization-treeview');
    return redirect('home');
});

Route::get('/your-role-is-empty', UserWithoutRoleController::class)->name('your-role-is-empty');

Route::middleware(['auth', 'ensure-user-has-a-role'])->group(function () {
    Route::get('/', HomeIndex::class)->name('home');
    Route::put('/switch-role/{role}', SwitchRoleController::class)->name('switch-role');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route::controller(AvatarImageController::class)->group(function () {
    //     Route::post('/profile/{workLog}/images', 'store')->name('workLogs.images.store');
    //     Route::delete('/profile/workLogs/{workLog}/images/{image}', 'destroy')->name('workLogs.images.destroy');
    // });

    Route::controller(StaffSectionController::class)->middleware([HRIsPermitted::class])->group(function() {
        Route::get('/bahagian/{staffSection}/unit/{staffUnit}/warga-kerja/cipta', 'create')->name('staff-sections.create');
        Route::post('/bahagian/{staffSection}/unit/{staffUnit}/warga-kerja', 'store')->name('staff-sections.store');
        Route::get('/bahagian/{staffSection}/unit/{staffUnit}/warga-kerja/{staff}', 'show')->name('staff-sections.show');
    });

    //     // HR uses
    Route::controller(StaffSectionController::class)->middleware([HRIsPermitted::class])->group(function() {
        Route::get('/bahagian/cipta', 'create')->name('staff-sections.create');
        Route::post('/bahagian', 'store')->name('staff-sections.store');
        Route::get('/bahagian', 'index')->name('staff-sections.index');
        Route::get('/bahagian/{staffSection}', 'show')->name('staff-sections.show');
        Route::post('/bahagian', 'store')->name('staff-sections.store');
        // Route::delete('/work-units', 'destroy')->name('work-units.destroy');
    });

    // HR uses
    // Route::controller(StaffUnitController::class)->middleware([HRIsPermitted::class])->group(function() {
    //     Route::get('/bahagian/{staffSection}/unit/cipta', 'create')->name('staff-units.create');
    //     Route::get('/bahagian/{staffSection}/unit', 'index')->name('staff-units.index');
    //     Route::get('/bahagian/{staffSection}/unit/{staffUnit}', 'show')->name('staff-units.show');
    //     Route::post('/bahagian/{staffSection}/unit', 'store')->name('staff-units.store');
    //     Route::put('/bahagian/{staffSection}/unit/{staffUnit}', 'update')->name('staff-sections.update');
    //    // Route::delete('/work-units', 'destroy')->name('work-units.destroy');
    // });

    Route::controller(WorkScopeController::class)->middleware([HRIsPermitted::class])->group(function() {
        Route::get('/work-scopes/create', 'create')->name('work-scopes.create');
        Route::get('/work-scopes', 'index')->name('work-scopes.index');
        Route::get('/work-scopes/{workScopes}', 'show')->name('work-scopes.show');
        Route::post('/work-scopes', 'store')->name('work-scopes.store');
        // Route::delete('/work-scopes', 'destroy')->name('work-scopes.destroy');
    });

    // HR uses
    // Route::controller(UserController::class)->middleware([HRIsPermitted::class])->group(function() {
    //     Route::get('/users/create', 'create')->name('users.create');
    //     Route::post('/users', 'store')->name('users.store');
    //     Route::post('/users', 'show')->name('users.show');
    //     Route::get('/users/{user}')->name('users.edit');
    //     Route::put('/users/{user}')->name('users.update');
    //     Route::delete('/users/{user}')->name('users.destory');
    // });

    // Staff | Evaluators share uses
    Route::controller(WorkLogController::class)->group(function () {
        // Route::get('/logkerja', 'index')->name('worklogs.index');
        Route::get('/logkerja/rekod-baharu', 'create')->name('worklogs.create');
        Route::get('/logkerja/{workLog}', 'show')->name('worklogs.show'); // + Edit
        // Creates revisions for every rejects, attaches comments if have any
        // Route::put('/logkerja/{workLog}/reject', 'reject');
        // Route::put('/logkerja/{workLog}/submit', 'submit');
        // Route::put('/logkerja/{workLog}/accept', 'accept');
        // Route::delete('/logkerja/buang', 'destroy');
        // Accessible from UI

        // === Staff
        // index, show (edit), update (submit), destroy (only before submission)

        // === Evaluators
        // index, show (edit), update (accept, reject, close)

        // Actions, hidden from UI, for system
        Route::post('/workLogs', 'store')->name('workLogs.store');
        Route::put('/workLogs/{workLog}/update', 'update')->name('workLogs.update');

    });

    /* -------------------  */
    /*  Content Management  */
    /* -------------------  */

    // Actions, hidden from UI, for system
    // Want to hide only for some people
    Route::controller(WorkLogImageController::class)->group(function () {
        Route::post('/workLogs/{workLog}/images', 'store')->name('workLogs.images.store');
        Route::delete('/workLogs/{workLog}/images/{image}', 'destroy')->name('workLogs.images.destroy');
    });

    Route::post('/workLogs/{workLog}/documents', [WorkLogDocumentController::class => 'store'])->name('workLogs.documents.store');
    Route::post('/workLogs/{workLog}/documents/{document}', [WorkLogDocumentController::class => 'destroy'])->name('workLogs.documents.destroy');

    // Route::controller(UsersController::class)->group(function () {
    //     Route::get('/users/cipta', 'create');
    //     Route::post('/users/{user}', 'show'); // + Edit
    //     Route::put('/users/{user}', 'update');

    //     Route::middleware(['must-be-admin'], function () {
    //         Route::post('/users', 'store');
    //         Route::delete('/users/buang', 'destroy');
    //     });
    // });

    /* -------------------  */
    /*  Temporary File Management  */
    /* -------------------  */
    Route::controller(TemporaryUploadController::class)->group(function () {
        Route::post('/temporary-uploads', 'process')->name('temporary-uploads.process');
        Route::delete('/temporary-uploads', 'revert')->name('temporary-uploads.revert');
        Route::get('/temporary-uploads', 'restore')->name('temporary-uploads.restore');
    });

});

Route::get('/that-query', function () {

    // return '';

    $datehere = new Carbon('2024-02-18');
    $latestSubmissions = Submission::select(DB::raw('work_log_id AS wl_id_fk'))
        ->orderBy('number', 'desc')
        ->limit(1);

    $something = WorkLog::leftJoin('work_scopes','work_logs.work_scope_id', '=', 'work_scopes.id')
    // ->leftJoin('submissions','work_logs.id', '=', 'submissions.work_log_id')
    ->join('users','users.id', '=', 'work_logs.author_id')
    ->with(['latestSubmission'])
    ->whereNotNull('wl_id_fk')
    // ->select(DB::raw('work_logs.id AS work_log_id'))
    ->joinSub($latestSubmissions, 'latest_submission_id', function (JoinClause $join) {
        $join->on('work_logs.id', '=', 'wl_id_fk');
    })
    ->get();

    return $something;

    $var = WorkLog::query()
        ->leftJoin('work_scopes','work_logs.work_scope_id', '=', 'work_scopes.id')
        ->leftJoin('submissions','work_logs.id', '=', 'submissions.work_log_id')
        ->join('users','users.id', '=', 'work_logs.author_id')
        ->where('work_logs.author_id', [
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
        // ->whereYear('work_logs.created_at', $datehere->copy()->addMonth()->format('Y'))
        ->where(function (Builder $q) use ($datehere) {
            $q->where(function (Builder $q) use ($datehere) {
                $q->whereNotNull('work_logs.created_at')
                ->whereRaw('YEAR(work_logs.created_at) <= ' . $datehere->format('Y'))
                ->whereRaw('MONTH(work_logs.created_at) <= ' . $datehere->format('m'));
                // ->whereYear('expected_at', '2024');
            })->where(function (Builder $q) use ($datehere) {
                $q->where(function (Builder $q) use ($datehere) {
                    $q->whereNotNull('work_logs.expected_at')
                    ->whereRaw('YEAR(work_logs.expected_at) >= ' . $datehere->format('Y'))
                    ->whereRaw('MONTH(work_logs.expected_at) >= ' . $datehere->format('m'));
                })
                ->orWhere(function (Builder $q) use ($datehere) {
                    $q->whereNotNull('submissions.submitted_at')
                    ->whereRaw('YEAR(submissions.submitted_at) >= ' . $datehere->format('Y'))
                    ->whereRaw('MONTH(submissions.submitted_at) >= ' . $datehere->format('m'));
                });
            });
        })
        ->orderBy('submissions.number')
        ->select('work_logs.id', 'users.name', 'work_scopes.title', DB::raw('submissions.id AS submissions_id'), 'submissions.number', 'submissions.submitted_at')
        // ->select('work_logs.*', 'users.name', 'work_scopes.title')
        // ->groupBy('work_logs.id')
        ->get();

    dd($var);

    return '';
});
