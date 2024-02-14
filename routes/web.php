<?php

use App\Helpers\UserRoleCodes;
use App\Http\Controllers\Home;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffSectionController;
use App\Http\Controllers\StaffUnitController;
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
use App\Models\User;
use App\Models\WorkLog;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

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
    Route::get('/', Home::class)->name('home');
    Route::put('/switch-role/{role}', SwitchRoleController::class)->name('switch-role');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

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
    Route::controller(StaffUnitController::class)->middleware([HRIsPermitted::class])->group(function() {
        Route::get('/bahagian/{staffSection}/unit/cipta', 'create')->name('staff-units.create');
        Route::get('/bahagian/{staffSection}/unit', 'index')->name('staff-units.index');
        Route::get('/bahagian/{staffSection}/unit/{staffUnit}', 'show')->name('staff-units.show');
        Route::post('/bahagian/{staffSection}/unit', 'store')->name('staff-units.store');
        Route::put('/bahagian/{staffSection}/unit/{staffUnit}', 'update')->name('staff-sections.update');
       // Route::delete('/work-units', 'destroy')->name('work-units.destroy');
    });

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
        Route::get('/logkerja', 'index')->name('worklogs.index');
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
    // OUTDATEDDDDD CHECK APP\HELPERS\WORKLOGCOUNTFORAYEAR
    $months_and_total_worklogs = WorkLog::join('users', 'work_logs.author_id', '=', 'users.id')
    ->join('staff_units', 'users.staff_unit_id', '=', 'staff_units.id')
    ->select(
        DB::raw("DATE_FORMAT(work_logs.started_at, '%M %Y') AS month"),
        DB::raw("COUNT(work_logs.id) as total")
    )
    ->groupBy('month')
    ->where('staff_units.id', 1)->distinct()->get()->toArray();
    // Transform into collection and make it into associative array; ['MONTH' => 'TOTAL']
    // Example: ['September 2023' => 5]
    $months_and_total_worklogs = collect($months_and_total_worklogs);
    $months_and_total_worklogs = $months_and_total_worklogs->mapWithKeys(function (array $item, int $key) {
        return [$item['month'] => $item['total']];
    });

    // Year to be prepared to generate months
    $searchYear = now()->subMonths(11)->format('Y');
    // Check if search year same as the current year
    $isCurrentYear = now()->format('Y') == $searchYear;

    // Track month to be iterated to prepare for the generated month
    $trackMonth = now()->setTime(0,0,0,0)->setDay(1);
    // If the current year is NOT the same as the search year (past years), generate for the whole year
    // If it's the same year, generate only up until current month (if right now is april, generate the list until april)
    if (! $isCurrentYear) $trackMonth->setMonth(12);

    $infiniteMonths = collect();
    Log::info('Starting year: '.$trackMonth->year);

    while ($trackMonth->year == $searchYear) {
        // Get total worklog from database for the created array
        $total_worklog_cursor =
            isset($months_and_total_worklogs[$trackMonth->format('F Y')])
                ? $months_and_total_worklogs[$trackMonth->format('F Y')] : 0;

        $infiniteMonths->push([
            'month' => $trackMonth->format('F Y'),
            'total' => $total_worklog_cursor,
        ]);

        Log::info('Before sub: '.$trackMonth);
        $trackMonth->subMonth();
        Log::info('After sub: '.$trackMonth);
    }

    // dd($trackMonth->year);
    dd($infiniteMonths);

    return '';
});
